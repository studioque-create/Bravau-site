<?php
$slug = $_GET['slug'] ?? '';
$posts = [];
$post = null;
if (file_exists('blog.json')) {
    $posts = json_decode(file_get_contents('blog.json'), true) ?: [];
    foreach ($posts as $p) {
        if (isset($p['slug']) && $p['slug'] === $slug) {
            $post = $p;
            break;
        }
    }
}
if (!$post) {
    header("Location: index.html");
    exit;
}

// Obter URL absoluta da imagem para Open Graph
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$domain = $protocol . $host;
$og_image = $domain . '/' . $post['image'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($post['title']); ?> | Bravau Auditores</title>
  <meta name="description" content="<?php echo htmlspecialchars($post['excerpt']); ?>">

  <!-- Meta tags de compartilhamento (Open Graph / Redes Sociais) -->
  <meta property="og:title" content="<?php echo htmlspecialchars($post['title']); ?> | Bravau Auditores">
  <meta property="og:description" content="<?php echo htmlspecialchars($post['excerpt']); ?>">
  <meta property="og:image" content="<?php echo $og_image; ?>">
  <meta property="og:type" content="article">
  <meta property="og:url" content="<?php echo $protocol . $host . $_SERVER['REQUEST_URI']; ?>">
  <meta name="twitter:card" content="summary_large_image">

  <!-- Fontes -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

  <style>
    /* ─── DESIGN SYSTEM TOKENS ─── */
    :root {
      --deep-onyx:    #1A1A1A;
      --charcoal:     #222222;
      --surface-dark: #2A2A2A;
      --gold:         #C9A84C;
      --gold-hover:   #E0BD62;
      --gold-muted:   #A8893D;
      --white:        #FFFFFF;
      --off-white:    #F0EDE8;
      --warm-gray:    #9A9A8A;
      --text-muted:   #7A7A6A;
    }

    *, *::before, *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: var(--deep-onyx);
      color: var(--off-white);
      font-family: "Inter", Arial, sans-serif;
      font-weight: 300;
      font-size: 16px;
      line-height: 1.6;
      overflow-x: hidden;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
    }

    /* ─── NAVIGATION (Replicado do site principal) ─── */
    nav {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: rgba(26, 26, 26, 0.9);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(201, 168, 76, 0.15);
      z-index: 100;
    }
    .nav-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
      height: 90px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo-wrap img {
      height: 48px;
      width: auto;
      display: block;
    }
    .nav-links {
      display: flex;
      align-items: center;
      gap: 32px;
      list-style: none;
    }
    .nav-links a {
      font-family: "Inter", sans-serif;
      font-weight: 500;
      font-size: 12.5px;
      text-transform: uppercase;
      color: var(--off-white);
      text-decoration: none;
      letter-spacing: 0.05em;
      transition: color 0.2s;
    }
    .nav-links a:hover { color: var(--gold); }
    .nav-links .nav-cta {
      padding: 10px 24px;
      background: var(--gold);
      color: var(--deep-onyx);
      font-weight: 600;
      transition: background-color 0.2s;
    }
    .nav-links .nav-cta:hover {
      background: var(--gold-hover);
      color: var(--deep-onyx);
    }

    /* Top banner */
    .top-banner {
      background: var(--charcoal);
      border-bottom: 1px solid rgba(201, 168, 76, 0.15);
      padding: 12px 24px;
      text-align: center;
      font-family: "Inter", sans-serif;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--warm-gray);
      margin-top: 90px;
    }
    .top-banner span {
      display: inline-block;
    }
    .top-banner-divider {
      margin: 0 8px;
      color: var(--gold);
    }

    /* Hamburger Menu para telas móveis */
    .menu-btn { display: none; }
    .menu-toggle-cb { display: none; }

    /* ─── POST TEMPLATE LAYOUT ─── */
    .post-wrapper {
      max-width: 800px;
      margin: 80px auto 120px;
      padding: 0 24px;
    }
    .post-header {
      margin-bottom: 40px;
    }
    .post-date {
      font-family: 'Inter', sans-serif;
      font-weight: 500;
      font-size: 11px;
      color: var(--gold);
      letter-spacing: 0.12em;
      text-transform: uppercase;
      display: block;
      margin-bottom: 16px;
    }
    h1.post-title {
      font-family: Georgia, serif;
      font-size: clamp(32px, 5.5vw, 52px);
      font-weight: 700;
      color: var(--white);
      line-height: 1.15;
      margin-bottom: 24px;
    }
    .post-excerpt {
      font-family: Georgia, serif;
      font-style: italic;
      font-size: clamp(18px, 2.5vw, 22px);
      color: var(--off-white);
      line-height: 1.6;
      border-left: 2px solid var(--gold);
      padding-left: 20px;
      margin-bottom: 40px;
    }
    .post-featured-image {
      width: 100%;
      max-height: 480px;
      object-fit: cover;
      border: 1px solid rgba(201, 168, 76, 0.35);
      margin-bottom: 48px;
      background: var(--charcoal);
    }
    .post-body {
      font-family: 'Inter', sans-serif;
      font-size: 18px;
      color: var(--off-white);
      line-height: 1.85;
      font-weight: 300;
    }
    .post-body p {
      margin-bottom: 28px;
    }

    /* CTA de rodapé do post */
    .post-cta {
      margin-top: 60px;
      padding-top: 40px;
      border-top: 1px solid rgba(201, 168, 76, 0.2);
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 24px;
    }
    .back-btn {
      color: var(--gold);
      text-decoration: none;
      font-weight: 600;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      transition: color 0.2s;
    }
    .back-btn:hover {
      color: var(--white);
    }
    .post-cta-button {
      padding: 14px 28px;
      background: var(--gold);
      color: var(--deep-onyx);
      font-family: "Inter", sans-serif;
      font-weight: 600;
      font-size: 12px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      text-decoration: none;
      transition: background-color 0.2s;
    }
    .post-cta-button:hover {
      background: var(--gold-hover);
    }

    /* ─── FOOTER ─── */
    footer {
      background: var(--charcoal);
      border-top: 1px solid rgba(201, 168, 76, 0.15);
      padding: 80px 0 40px;
    }
    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr;
      gap: 64px;
      margin-bottom: 64px;
    }
    .footer-brand p {
      font-size: 14px;
      color: var(--warm-gray);
      margin-top: 16px;
      max-width: 320px;
    }
    .footer-col h4 {
      font-family: "Inter", sans-serif;
      font-weight: 600;
      font-size: 12px;
      text-transform: uppercase;
      color: var(--gold);
      letter-spacing: 0.1em;
      margin-bottom: 24px;
    }
    .footer-col ul { list-style: none; }
    .footer-col ul li { margin-bottom: 10px; }
    .footer-col ul li a {
      font-size: 14px;
      color: var(--warm-gray);
      text-decoration: none;
      transition: color 0.2s;
    }
    .footer-col ul li a:hover { color: var(--off-white); }
    .footer-hr { height: 1px; background: rgba(201, 168, 76, 0.2); margin-bottom: 28px; }
    .footer-bottom {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 12px;
    }
    .footer-cert, .footer-copy {
      font-family: "Inter", sans-serif;
      font-weight: 300;
      font-size: 12px;
      color: var(--warm-gray);
      letter-spacing: 0.06em;
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 960px) {
      .footer-grid { grid-template-columns: 1fr; gap: 40px; }
      
      /* Hamburguer menu */
      .menu-btn {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 30px;
        height: 20px;
        cursor: pointer;
        z-index: 110;
      }
      .menu-btn span {
        display: block;
        height: 2px;
        width: 100%;
        background: var(--off-white);
        transition: transform 0.3s, opacity 0.3s;
      }
      .nav-links {
        position: fixed;
        top: 0;
        right: 0;
        width: 100%;
        height: 100vh;
        background: var(--deep-onyx);
        flex-direction: column;
        justify-content: center;
        gap: 40px;
        padding: 40px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s, visibility 0.3s;
        z-index: 105;
      }
      .menu-toggle-cb:checked ~ .nav-links {
        opacity: 1;
        visibility: visible;
      }
      .menu-toggle-cb:checked ~ .menu-btn span:nth-child(1) {
        transform: translateY(9px) rotate(45deg);
      }
      .menu-toggle-cb:checked ~ .menu-btn span:nth-child(2) {
        opacity: 0;
      }
      .menu-toggle-cb:checked ~ .menu-btn span:nth-child(3) {
        transform: translateY(-9px) rotate(-45deg);
      }
    }
  </style>
</head>
<body>

  <!-- ═══════════════════════════════
       NAVIGATION
  ═══════════════════════════════ -->
  <nav>
    <div class="nav-inner">
      <a href="/index.php" class="logo-wrap">
        <img src="/Logo Bravau.png" alt="Bravau Auditores">
      </a>

      <!-- Controle de estado do Menu (Checkbox Hack) -->
      <input type="checkbox" id="menu-toggle" class="menu-toggle-cb">

      <!-- Ícone Hambúrguer -->
      <label for="menu-toggle" class="menu-btn">
        <span></span>
        <span></span>
        <span></span>
      </label>

      <ul class="nav-links">
        <li><a href="/index.php#quem-somos" onclick="document.getElementById('menu-toggle').checked = false">Quem Somos</a></li>
        <li><a href="/index.php#servicos" onclick="document.getElementById('menu-toggle').checked = false">Serviços</a></li>
        <li><a href="/index.php#diferenciais" onclick="document.getElementById('menu-toggle').checked = false">Por que Bravau</a></li>
        <li><a href="/index.php#resultados" onclick="document.getElementById('menu-toggle').checked = false">Resultados</a></li>
        <li><a href="/blog.php" onclick="document.getElementById('menu-toggle').checked = false">Blog</a></li>
        <li><a href="https://wa.me/5562992888257?text=Olá,%20gostaria%20de%20falar%20com%20um%20especialista%20da%20Bravau." target="_blank" class="btn-primary nav-cta" onclick="document.getElementById('menu-toggle').checked = false">Fale com um especialista</a></li>
      </ul>
    </div>
  </nav>

  <div class="top-banner">
    <span class="top-banner-title">Auditores Certificados pelo Banco Central e CVM</span>
    <span class="top-banner-divider">·</span>
    <span class="top-banner-standards">IFRS &nbsp;·&nbsp; CPC &nbsp;·&nbsp; US GAAP</span>
  </div>

  <!-- ═══════════════════════════════
       CONTEÚDO DO ARTIGO
  ═══════════════════════════════ -->
  <main class="post-wrapper">
    <article class="post-content">
      <header class="post-header">
        <span class="post-date"><?php echo htmlspecialchars($post['date']); ?></span>
        <h1 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h1>
        <div class="post-excerpt">
          <?php echo htmlspecialchars($post['excerpt']); ?>
        </div>
      </header>

      <?php if (!empty($post['image'])): ?>
        <img src="/<?php echo htmlspecialchars($post['image']); ?>" class="post-featured-image" alt="Imagem Destacada">
      <?php endif; ?>

      <div class="post-body">
        <?php 
        // Renderizar parágrafos divididos por quebras de linha
        $paragraphs = explode("\n", $post['body']);
        foreach ($paragraphs as $p) {
            $p = trim($p);
            if ($p !== '') {
                echo '<p>' . htmlspecialchars($p) . '</p>';
            }
        }
        ?>
      </div>

      <footer class="post-cta">
        <a href="/blog.php" class="back-btn">← Voltar ao Blog</a>
        <a href="https://wa.me/5562992888257?text=Olá,%20li%20o%20artigo%20'<?php echo urlencode($post['title']); ?>'%20e%20gostaria%20de%20tirar%20algumas%20dúvidas." target="_blank" class="post-cta-button">Falar no WhatsApp</a>
      </footer>
    </article>
  </main>

  <!-- ═══════════════════════════════
       FOOTER
  ═══════════════════════════════ -->
  <footer>
    <div class="container">
      <div class="footer-grid">

        <div class="footer-brand">
          <img src="/Logo Bravau.png" alt="Bravau Auditores" height="48" style="height:48px;width:auto;display:block;margin-bottom:10px;">
          <p>Padrão Big Four para o mercado brasileiro de médio porte. Certificados, comprometidos, rastreáveis.</p>
        </div>

        <div class="footer-col">
          <h4>Serviços</h4>
          <ul>
            <li><a href="/index.php#servicos">Reforma Tributária</a></li>
            <li><a href="/index.php#servicos">Estruturação do Negócio</a></li>
            <li><a href="/index.php#servicos">Auditoria Consultiva</a></li>
            <li><a href="/index.php#servicos">Implantação de ERP</a></li>
            <li><a href="/index.php#servicos">Gestão para Criação de Valor</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Contato</h4>
          <ul>
            <li><a href="mailto:contato@bravau.com.br">contato@bravau.com.br</a></li>
            <li><a href="https://wa.me/5562992888257" target="_blank">WhatsApp: (62) 99288-8257</a></li>
            <li><a href="#">Goiânia, GO</a></li>
          </ul>

        </div>

      </div>

      <div class="footer-hr"></div>

      <div class="footer-bottom">
        <p class="footer-cert">Certificados pelo Banco Central e CVM &nbsp;·&nbsp; IFRS &nbsp;·&nbsp; CPC &nbsp;·&nbsp; US GAAP</p>
        <p class="footer-copy">© 2026 Bravau Auditores. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>

</body>
</html>
