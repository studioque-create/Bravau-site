<?php
$posts = [];
if (file_exists('blog.json')) {
    $posts = json_decode(file_get_contents('blog.json'), true) ?: [];
}
$is_localhost = ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog — Artigos & Insights | Bravau Auditores</title>
  <meta name="description" content="Análises de auditoria, tributação e finanças estratégicas para o médio mercado brasileiro.">

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

    /* ─── NAVIGATION ─── */
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

    /* Hamburger Menu */
    .menu-btn { display: none; }
    .menu-toggle-cb { display: none; }

    /* ─── HERO ─── */
    .blog-hero {
      padding: 100px 0 60px;
      border-bottom: 1px solid rgba(201, 168, 76, 0.1);
      margin-bottom: 80px;
    }
    .eyebrow {
      display: inline-block;
      font-family: "Inter", sans-serif;
      font-weight: 600;
      font-size: 10.5px;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      color: var(--deep-onyx);
      background: var(--gold);
      padding: 6px 14px;
      margin-bottom: 24px;
    }
    .blog-hero-title {
      font-family: Georgia, serif;
      font-size: clamp(32px, 5vw, 56px);
      font-weight: 400;
      color: var(--white);
      line-height: 1.15;
      margin-bottom: 20px;
    }
    .blog-hero-lead {
      font-size: clamp(16px, 2vw, 20px);
      color: var(--warm-gray);
      max-width: 700px;
      line-height: 1.6;
    }

    /* ─── BLOG GRID ─── */
    .blog-section {
      padding-bottom: 120px;
    }
    .blog-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 32px;
    }
    .blog-card {
      background: var(--charcoal);
      border-top: 3px solid var(--gold);
      padding: 40px 32px;
      display: flex;
      flex-direction: column;
      height: 100%;
      transition: background 0.25s ease, transform 0.25s ease;
      text-decoration: none;
      position: relative;
      overflow: hidden;
      min-height: 320px;
    }
    .blog-card::before {
      content: "";
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      background: linear-gradient(rgba(26, 26, 26, 0.85), rgba(26, 26, 26, 0.95));
      z-index: 1;
    }
    .blog-card > * {
      position: relative;
      z-index: 2;
    }
    .blog-card:hover {
      transform: translateY(-4px);
    }
    .blog-date {
      font-family: 'Inter', sans-serif;
      font-weight: 500;
      font-size: 11px;
      color: var(--gold);
      letter-spacing: 0.1em;
      text-transform: uppercase;
      margin-bottom: 16px;
    }
    .blog-title {
      font-family: Georgia, serif;
      font-weight: 700;
      font-size: 22px;
      color: var(--white);
      line-height: 1.3;
      margin-bottom: 16px;
    }
    .blog-excerpt {
      font-family: 'Inter', sans-serif;
      font-size: 15px;
      color: var(--warm-gray);
      line-height: 1.65;
      margin-bottom: 28px;
      flex-grow: 1;
    }
    .blog-link {
      font-family: 'Inter', sans-serif;
      font-weight: 600;
      font-size: 12px;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      display: inline-flex;
      align-items: center;
      transition: color 0.2s;
    }
    .blog-card:hover .blog-link {
      color: var(--white);
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
      font-size: 13px;
      color: var(--text-muted);
    }
    .footer-cert {
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }
    .footer-copy {
      font-weight: 400;
    }

    .btn-primary {
      background: var(--gold);
      color: var(--deep-onyx);
      font-weight: 600;
      text-transform: uppercase;
      text-decoration: none;
      letter-spacing: 0.08em;
      padding: 12px 28px;
      font-size: 12px;
      display: inline-block;
      transition: background-color 0.2s;
    }
    .btn-primary:hover {
      background: var(--gold-hover);
    }

    /* Responsive */
    @media (max-width: 960px) {
      .blog-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
      .footer-grid { grid-template-columns: 1fr; gap: 40px; }
    }

    @media (max-width: 768px) {
      .blog-grid { grid-template-columns: 1fr; }
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
        <li><a href="/blog.php" onclick="document.getElementById('menu-toggle').checked = false" style="color: var(--gold);">Blog</a></li>
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
       HERO
  ═══════════════════════════════ -->
  <section class="blog-hero">
    <div class="container">
      <span class="eyebrow">Artigos & Insights</span>
      <h1 class="blog-hero-title">Conhecimento que gera valor contábil.</h1>
      <p class="blog-hero-lead">Análises de auditoria, tributação e finanças estratégicas para o médio mercado brasileiro.</p>
    </div>
  </section>

  <!-- ═══════════════════════════════
       CONTEÚDO DO BLOG
  ═══════════════════════════════ -->
  <main class="blog-section">
    <div class="container">
      <?php if (empty($posts)): ?>
        <p style="color: var(--warm-gray); text-align: center; padding: 60px 0; font-size: 18px;">Nenhum artigo publicado ainda.</p>
      <?php else: ?>
        <div class="blog-grid">
          <?php foreach ($posts as $p): 
            $post_url = $is_localhost ? "post.php?slug=" . $p['slug'] : "/artigo/" . $p['slug'];
          ?>
            <a href="<?php echo $post_url; ?>" class="blog-card" style="background-image: url('/<?php echo htmlspecialchars($p['image'] ?? 'bravau_hero_bg.jpg'); ?>'); background-size: cover; background-position: center;">
              <span class="blog-date"><?php echo htmlspecialchars($p['date']); ?></span>
              <h3 class="blog-title"><?php echo htmlspecialchars($p['title']); ?></h3>
              <p class="blog-excerpt"><?php echo htmlspecialchars($p['excerpt']); ?></p>
              <span class="blog-link">Ler artigo →</span>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
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
