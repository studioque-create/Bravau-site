<?php
session_start();

// Configurações
define('PASSWORD', 'bravau1234'); // ALTERE ESTA SENHA PARA A SUA SEGURANÇA
define('JSON_FILE', 'blog.json');
define('CONTENT_FILE', 'site_content.json');

// Autenticação
if (isset($_POST['login'])) {
    $password = $_POST['password'] ?? '';
    if ($password === PASSWORD) {
        $_SESSION['logged_in'] = true;
    } else {
        $error = "Senha incorreta.";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Proteção da página
$logged_in = $_SESSION['logged_in'] ?? false;

// Função auxiliar para gerar URL amigável (slug)
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    if (function_exists('iconv')) {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

// CRUD e Lógica de Edição (só se logado)
if ($logged_in) {
    // Carregar posts do Blog
    $posts = [];
    if (file_exists(JSON_FILE)) {
        $json_data = file_get_contents(JSON_FILE);
        $posts = json_decode($json_data, true) ?: [];
    }

    // Carregar conteúdo do site
    $home = [];
    if (file_exists(CONTENT_FILE)) {
        $home = json_decode(file_get_contents(CONTENT_FILE), true) ?: [];
    }

    $tab = $_GET['tab'] ?? 'blog';
    $edit_index = isset($_GET['edit']) ? (int)$_GET['edit'] : -1;

    // Salvar Artigo do Blog
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_post'])) {
        $date = trim($_POST['date'] ?? date('d M Y'));
        $title = trim($_POST['title'] ?? '');
        $excerpt = trim($_POST['excerpt'] ?? '');
        $body = trim($_POST['body'] ?? '');
        $image = $_POST['current_image'] ?? 'bravau_hero_bg.jpg';

        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['featured_image']['tmp_name'];
            $fileName = $_FILES['featured_image']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            
            if (in_array($fileExtension, $allowedfileExtensions)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadFileDir = 'uploads/';
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }
                $dest_path = $uploadFileDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $image = $dest_path;
                }
            }
        }

        if ($title !== '') {
            $slug = slugify($title);
            $slug_candidate = $slug;
            $counter = 1;
            foreach ($posts as $idx => $p) {
                if ($idx !== $edit_index && isset($p['slug']) && $p['slug'] === $slug_candidate) {
                    $slug_candidate = $slug . '-' . $counter;
                    $counter++;
                }
            }
            $slug = $slug_candidate;

            $new_post = [
                'date' => $date,
                'slug' => $slug,
                'title' => $title,
                'excerpt' => $excerpt,
                'image' => $image,
                'body' => $body
            ];

            if ($edit_index >= 0 && isset($posts[$edit_index])) {
                $posts[$edit_index] = $new_post;
            } else {
                array_unshift($posts, $new_post);
            }

            file_put_contents(JSON_FILE, json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            header("Location: admin.php?tab=blog");
            exit;
        }
    }

    // Excluir Artigo do Blog
    if ($tab === 'blog' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['index'])) {
        $delete_index = (int)$_GET['index'];
        if (isset($posts[$delete_index])) {
            $img_path = $posts[$delete_index]['image'];
            if ($img_path !== 'bravau_hero_bg.jpg' && file_exists($img_path)) {
                @unlink($img_path);
            }
            array_splice($posts, $delete_index, 1);
            file_put_contents(JSON_FILE, json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
        header("Location: admin.php?tab=blog");
        exit;
    }

    // Salvar Conteúdo Geral do Site
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_content'])) {
        $new_content = [
            'top_banner' => [
                'title' => trim($_POST['tb_title'] ?? ''),
                'standards' => trim($_POST['tb_standards'] ?? '')
            ],
            'hero' => [
                'title' => trim($_POST['hero_title'] ?? ''),
                'lead' => trim($_POST['hero_lead'] ?? ''),
                'kpi_label' => trim($_POST['hero_kpi_label'] ?? '')
            ],
            'metrics' => [
                'm1_val' => trim($_POST['m1_val'] ?? ''),
                'm1_label' => trim($_POST['m1_label'] ?? ''),
                'm1_desc' => trim($_POST['m1_desc'] ?? ''),
                'm2_val' => trim($_POST['m2_val'] ?? ''),
                'm2_label' => trim($_POST['m2_label'] ?? ''),
                'm2_desc' => trim($_POST['m2_desc'] ?? ''),
                'm3_val' => trim($_POST['m3_val'] ?? ''),
                'm3_label' => trim($_POST['m3_label'] ?? ''),
                'm3_desc' => trim($_POST['m3_desc'] ?? '')
            ],
            'problem_solution' => [
                'prob_eyebrow' => trim($_POST['prob_eyebrow'] ?? 'O Problema'),
                'prob_title' => trim($_POST['prob_title'] ?? ''),
                'prob_body' => trim($_POST['prob_body'] ?? ''),
                'sol_eyebrow' => trim($_POST['sol_eyebrow'] ?? 'A Solução'),
                'sol_title' => trim($_POST['sol_title'] ?? ''),
                'sol_body' => trim($_POST['sol_body'] ?? '')
            ],
            'services' => [],
            'why_bravau' => [
                'eyebrow' => trim($_POST['why_eyebrow'] ?? 'Por que Bravau'),
                'title' => trim($_POST['why_title'] ?? ''),
                'metric_val' => trim($_POST['why_metric_val'] ?? ''),
                'metric_label' => trim($_POST['why_metric_label'] ?? ''),
                'differentials' => []
            ],
            'about' => [
                'left_eyebrow' => trim($_POST['about_left_eyebrow'] ?? 'Quem Somos'),
                'left_title' => trim($_POST['about_left_title'] ?? ''),
                'left_body' => trim($_POST['about_left_body'] ?? ''),
                'right_eyebrow' => trim($_POST['about_right_eyebrow'] ?? 'Diferencial'),
                'right_title' => trim($_POST['about_right_title'] ?? ''),
                'right_body' => trim($_POST['about_right_body'] ?? '')
            ],
            'cta' => [
                'eyebrow' => trim($_POST['cta_eyebrow'] ?? 'Próximo Passo'),
                'title' => trim($_POST['cta_title'] ?? ''),
                'lead' => trim($_POST['cta_lead'] ?? ''),
                'note' => trim($_POST['cta_note'] ?? '')
            ],
            'contact' => [
                'email' => trim($_POST['contact_email'] ?? ''),
                'phone' => trim($_POST['contact_phone'] ?? ''),
                'address' => trim($_POST['contact_address'] ?? '')
            ]
        ];

        // Processar serviços
        for ($i = 0; $i < 5; $i++) {
            $new_content['services'][] = [
                'label' => trim($_POST['svc_label_'.$i] ?? ''),
                'title' => trim($_POST['svc_title_'.$i] ?? ''),
                'tagline' => trim($_POST['svc_tagline_'.$i] ?? ''),
                'body' => trim($_POST['svc_body_'.$i] ?? '')
            ];
        }

        // Processar diferenciais
        for ($i = 0; $i < 4; $i++) {
            $new_content['why_bravau']['differentials'][] = [
                'n' => trim($_POST['diff_n_'.$i] ?? sprintf('%02d', $i+1)),
                'title' => trim($_POST['diff_title_'.$i] ?? ''),
                'desc' => trim($_POST['diff_desc_'.$i] ?? '')
            ];
        }

        // Criar cópia de segurança antes de gravar
        if (file_exists(CONTENT_FILE)) {
            copy(CONTENT_FILE, CONTENT_FILE . '.bak');
        }

        file_put_contents(CONTENT_FILE, json_encode($new_content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        header("Location: admin.php?tab=content&saved=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bravau CMS — Gestão do Site</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --deep-onyx:   #1A1A1A;
      --charcoal:    #222222;
      --surface-dark:#2A2A2A;
      --gold:        #C9A84C;
      --gold-muted:  #A8893D;
      --white:       #FFFFFF;
      --off-white:   #F0EDE8;
      --warm-gray:   #9A9A8A;
      --border-color: rgba(201, 168, 76, 0.2);
    }

    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      background: var(--deep-onyx);
      color: var(--off-white);
      font-family: "Inter", Arial, sans-serif;
      font-weight: 300;
      font-size: 15px;
      line-height: 1.6;
      padding: 40px 20px;
    }

    .container {
      max-width: 960px;
      margin: 0 auto;
    }

    /* Header */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid var(--border-color);
      padding-bottom: 20px;
      margin-bottom: 30px;
    }
    h1 {
      font-family: Georgia, serif;
      color: var(--white);
      font-size: 26px;
    }
    h1 span {
      color: var(--gold);
    }
    .logout-btn {
      color: var(--warm-gray);
      text-decoration: none;
      font-size: 13px;
    }
    .logout-btn:hover {
      color: var(--gold);
    }

    /* Tabs */
    .tabs {
      display: flex;
      gap: 10px;
      margin-bottom: 30px;
      border-bottom: 1px solid var(--border-color);
      padding-bottom: 16px;
    }
    .tab-btn {
      color: var(--warm-gray);
      text-decoration: none;
      font-weight: 600;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      padding: 10px 20px;
      border: 1px solid transparent;
      transition: all 0.2s ease;
    }
    .tab-btn:hover {
      color: var(--gold);
    }
    .tab-btn.active {
      color: var(--deep-onyx);
      background: var(--gold);
      border-color: var(--gold);
    }

    /* Cards */
    .card {
      background: var(--charcoal);
      border-top: 3px solid var(--gold);
      padding: 32px;
      margin-bottom: 30px;
    }
    .section-title {
      font-family: Georgia, serif;
      color: var(--white);
      font-size: 18px;
      margin-bottom: 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      padding-bottom: 10px;
    }
    .sub-section {
      background: rgba(0, 0, 0, 0.15);
      padding: 20px;
      margin-bottom: 24px;
      border-left: 2px solid var(--gold);
    }
    h3.sub-title {
      font-size: 15px;
      color: var(--white);
      margin-bottom: 15px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    /* Forms */
    .form-group {
      margin-bottom: 18px;
    }
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    .form-grid-three {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 16px;
    }
    label {
      display: block;
      font-size: 12px;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 6px;
      font-weight: 600;
    }
    input[type="text"], input[type="password"], input[type="file"], textarea {
      width: 100%;
      background: var(--deep-onyx);
      border: 1px solid rgba(201, 168, 76, 0.25);
      color: var(--white);
      padding: 10px 12px;
      font-family: "Inter", sans-serif;
      font-size: 14px;
      font-weight: 300;
      border-radius: 0;
    }
    input[type="text"]:focus, input[type="password"]:focus, textarea:focus {
      outline: none;
      border-color: var(--gold);
    }
    textarea {
      resize: vertical;
      min-height: 80px;
    }
    
    .btn {
      display: inline-block;
      background: var(--gold);
      color: var(--deep-onyx);
      font-family: "Inter", sans-serif;
      font-weight: 600;
      font-size: 11px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      padding: 12px 28px;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: background 0.2s ease;
    }
    .btn:hover {
      background: var(--gold-muted);
    }
    .btn-secondary {
      background: transparent;
      border: 1px solid var(--warm-gray);
      color: var(--warm-gray);
      margin-left: 12px;
    }
    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.05);
      color: var(--white);
    }

    /* List Table */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid rgba(201, 168, 76, 0.1);
    }
    th {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--gold);
      font-weight: 600;
    }
    td { font-size: 14px; }
    .post-date { color: var(--warm-gray); font-size: 12px; }
    .post-title { font-family: Georgia, serif; color: var(--white); font-weight: 600; }
    .actions { display: flex; gap: 12px; }
    .action-link {
      color: var(--gold);
      text-decoration: none;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
    }
    .action-link:hover { color: var(--white); }
    .action-delete { color: #ff5555; }
    .action-delete:hover { color: #ff9999; }
    .img-preview {
      width: 70px;
      height: 40px;
      object-fit: cover;
      border: 1px solid rgba(201, 168, 76, 0.2);
    }

    /* Success message */
    .success-alert {
      background: rgba(201, 168, 76, 0.15);
      border: 1px solid var(--gold);
      color: var(--off-white);
      padding: 16px;
      margin-bottom: 24px;
      font-size: 14px;
    }
    .login-container {
      max-width: 400px;
      margin: 100px auto 0;
      background: var(--charcoal);
      border-top: 3px solid var(--gold);
      padding: 40px 32px;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="container">

  <?php if (!$logged_in): ?>
    <div class="login-container">
      <div style="margin-bottom: 30px;">
        <h1 style="font-size: 32px;">Brav<span>Au</span></h1>
        <p style="font-size: 10px; letter-spacing: 0.15em; color: var(--warm-gray); text-transform: uppercase; margin-top: 5px;">CMS do Site</p>
      </div>
      
      <?php if (isset($error)): ?>
        <div style="color:#ff5555; font-size:14px; margin-bottom:20px;"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <form action="admin.php" method="POST">
        <div class="form-group" style="text-align: left;">
          <label for="password">Senha de Acesso</label>
          <input type="password" id="password" name="password" required autofocus>
        </div>
        <button type="submit" name="login" class="btn" style="width: 100%; padding: 14px;">Entrar no Painel</button>
      </form>
    </div>

  <?php else: ?>
    <!-- Painel Logado -->
    <header>
      <div>
        <h1>Brav<span>Au</span></h1>
        <p style="font-size: 10px; letter-spacing: 0.15em; color: var(--warm-gray); text-transform: uppercase;">Gestão Global do Site</p>
      </div>
      <a href="admin.php?logout=1" class="logout-btn">Sair do Painel</a>
    </header>

    <div class="tabs">
      <a href="admin.php?tab=blog" class="tab-btn <?php echo $tab === 'blog' ? 'active' : ''; ?>">Gerenciar Blog</a>
      <a href="admin.php?tab=content" class="tab-btn <?php echo $tab === 'content' ? 'active' : ''; ?>">Editar Página Inicial</a>
    </div>

    <?php if (isset($_GET['saved']) && $_GET['saved'] == 1): ?>
      <div class="success-alert">
        ✓ Configurações da página inicial atualizadas com sucesso! Um backup preventivo foi criado.
      </div>
    <?php endif; ?>

    <!-- ═══════════════════════════════
         TAB: BLOG (ARTIGOS)
    ═══════════════════════════════ -->
    <?php if ($tab === 'blog'): ?>
      <?php
      $is_editing = $edit_index >= 0 && isset($posts[$edit_index]);
      $form_title = $is_editing ? "Editar Artigo" : "Criar Novo Artigo";
      $current_date = $is_editing ? $posts[$edit_index]['date'] : date('d M Y');
      $current_title = $is_editing ? $posts[$edit_index]['title'] : '';
      $current_excerpt = $is_editing ? $posts[$edit_index]['excerpt'] : '';
      $current_body = $is_editing ? $posts[$edit_index]['body'] : '';
      $current_image = $is_editing ? $posts[$edit_index]['image'] : 'bravau_hero_bg.jpg';
      ?>

      <div class="card">
        <h2 class="section-title"><?php echo $form_title; ?></h2>
        <form action="admin.php?tab=blog<?php echo $is_editing ? '&edit=' . $edit_index : ''; ?>" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title">Título do Artigo</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($current_title); ?>" required>
          </div>
          
          <div class="form-group">
            <label for="date">Data de Publicação</label>
            <input type="text" id="date" name="date" value="<?php echo htmlspecialchars($current_date); ?>">
          </div>

          <div class="form-group">
            <label for="featured_image">Imagem Destacada (JPG, PNG, WEBP)</label>
            <input type="file" id="featured_image" name="featured_image" accept="image/*">
            <?php if ($is_editing): ?>
              <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($current_image); ?>">
              <p style="font-size: 13px; color: var(--warm-gray); margin-top: 8px; display: flex; align-items: center; gap: 10px;">
                <span>Imagem atual: <code><?php echo htmlspecialchars($current_image); ?></code></span>
                <img src="<?php echo htmlspecialchars($current_image); ?>" class="img-preview" alt="Preview">
              </p>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="excerpt">Resumo (Exibido na página inicial)</label>
            <textarea id="excerpt" name="excerpt" required><?php echo htmlspecialchars($current_excerpt); ?></textarea>
          </div>

          <div class="form-group">
            <label for="body">Conteúdo Completo (Pressione Enter duplo para iniciar novos parágrafos)</label>
            <textarea id="body" name="body" style="min-height: 200px;" required><?php echo htmlspecialchars($current_body); ?></textarea>
          </div>

          <button type="submit" name="save_post" class="btn">Salvar Artigo</button>
          <?php if ($is_editing): ?>
            <a href="admin.php?tab=blog" class="btn btn-secondary">Cancelar Edição</a>
          <?php endif; ?>
        </form>
      </div>

      <div class="card">
        <h2 class="section-title">Artigos Publicados (<?php echo count($posts); ?>)</h2>
        <?php if (empty($posts)): ?>
          <p style="color: var(--warm-gray); text-align: center; padding: 20px 0;">Nenhum artigo publicado ainda.</p>
        <?php else: ?>
          <table>
            <thead>
              <tr>
                <th style="width: 10%;">Imagem</th>
                <th style="width: 15%;">Data</th>
                <th style="width: 50%;">Título</th>
                <th style="width: 25%;">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($posts as $index => $post): ?>
                <tr>
                  <td><img src="<?php echo htmlspecialchars($post['image'] ?? 'bravau_hero_bg.jpg'); ?>" class="img-preview" alt="Thumb"></td>
                  <td><span class="post-date"><?php echo htmlspecialchars($post['date']); ?></span></td>
                  <td>
                    <span class="post-title"><?php echo htmlspecialchars($post['title']); ?></span><br>
                    <span style="font-size:11px; color:var(--warm-gray);">URL: <code>artigo/<?php echo htmlspecialchars($post['slug'] ?? ''); ?></code></span>
                  </td>
                  <td>
                    <div class="actions">
                      <a href="admin.php?tab=blog&edit=<?php echo $index; ?>" class="action-link">Editar</a>
                      <a href="admin.php?tab=blog&action=delete&index=<?php echo $index; ?>" onclick="return confirm('Deseja realmente excluir este artigo?')" class="action-link action-delete">Excluir</a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>

    <!-- ═══════════════════════════════
         TAB: CONTEÚDO DA PÁGINA INICIAL
    ═══════════════════════════════ -->
    <?php elseif ($tab === 'content'): ?>
      <form action="admin.php?tab=content" method="POST">
        
        <!-- SEÇÃO: CABEÇALHO & HERO -->
        <div class="card">
          <h2 class="section-title">1. Cabeçalho & Hero (Abertura)</h2>
          
          <div class="form-grid">
            <div class="form-group">
              <label for="tb_title">Título do Banner Superior</label>
              <input type="text" id="tb_title" name="tb_title" value="<?php echo htmlspecialchars($home['top_banner']['title'] ?? ''); ?>">
            </div>
            <div class="form-group">
              <label for="tb_standards">Normas/Certificações do Banner</label>
              <input type="text" id="tb_standards" name="tb_standards" value="<?php echo htmlspecialchars($home['top_banner']['standards'] ?? ''); ?>">
            </div>
          </div>

          <div class="form-group">
            <label for="hero_title">Título Principal (Hero - Aceita quebra de linha)</label>
            <textarea id="hero_title" name="hero_title" required><?php echo htmlspecialchars($home['hero']['title'] ?? ''); ?></textarea>
          </div>

          <div class="form-group">
            <label for="hero_lead">Texto de Apoio (Lead)</label>
            <textarea id="hero_lead" name="hero_lead" required><?php echo htmlspecialchars($home['hero']['lead'] ?? ''); ?></textarea>
          </div>

          <div class="form-group">
            <label for="hero_kpi_label">Texto do Cifrão ($) Overlaid (Aceita &lt;br&gt;)</label>
            <input type="text" id="hero_kpi_label" name="hero_kpi_label" value="<?php echo htmlspecialchars($home['hero']['kpi_label'] ?? ''); ?>">
          </div>
        </div>

        <!-- SEÇÃO: MÉTRICAS (NÚMEROS) -->
        <div class="card">
          <h2 class="section-title">2. Métricas de Resultados</h2>
          
          <div class="sub-section">
            <h3 class="sub-title">Métrica 1</h3>
            <div class="form-grid">
              <div class="form-group">
                <label>Número/Porcentagem</label>
                <input type="text" name="m1_val" value="<?php echo htmlspecialchars($home['metrics']['m1_val'] ?? ''); ?>">
              </div>
              <div class="form-group">
                <label>Rótulo Curto</label>
                <input type="text" name="m1_label" value="<?php echo htmlspecialchars($home['metrics']['m1_label'] ?? ''); ?>">
              </div>
            </div>
            <div class="form-group">
              <label>Descrição do Resultado</label>
              <textarea name="m1_desc"><?php echo htmlspecialchars($home['metrics']['m1_desc'] ?? ''); ?></textarea>
            </div>
          </div>

          <div class="sub-section">
            <h3 class="sub-title">Métrica 2</h3>
            <div class="form-grid">
              <div class="form-group">
                <label>Número/Porcentagem</label>
                <input type="text" name="m2_val" value="<?php echo htmlspecialchars($home['metrics']['m2_val'] ?? ''); ?>">
              </div>
              <div class="form-group">
                <label>Rótulo Curto</label>
                <input type="text" name="m2_label" value="<?php echo htmlspecialchars($home['metrics']['m2_label'] ?? ''); ?>">
              </div>
            </div>
            <div class="form-group">
              <label>Descrição do Resultado</label>
              <textarea name="m2_desc"><?php echo htmlspecialchars($home['metrics']['m2_desc'] ?? ''); ?></textarea>
            </div>
          </div>

          <div class="sub-section">
            <h3 class="sub-title">Métrica 3</h3>
            <div class="form-grid">
              <div class="form-group">
                <label>Número/Porcentagem</label>
                <input type="text" name="m3_val" value="<?php echo htmlspecialchars($home['metrics']['m3_val'] ?? ''); ?>">
              </div>
              <div class="form-group">
                <label>Rótulo Curto</label>
                <input type="text" name="m3_label" value="<?php echo htmlspecialchars($home['metrics']['m3_label'] ?? ''); ?>">
              </div>
            </div>
            <div class="form-group">
              <label>Descrição do Resultado</label>
              <textarea name="m3_desc"><?php echo htmlspecialchars($home['metrics']['m3_desc'] ?? ''); ?></textarea>
            </div>
          </div>
        </div>

        <!-- SEÇÃO: PROBLEMA E SOLUÇÃO -->
        <div class="card">
          <h2 class="section-title">3. O Problema vs. A Solução</h2>
          
          <div class="form-grid">
            <div class="sub-section" style="margin-bottom:0;">
              <h3 class="sub-title">O Problema</h3>
              <div class="form-group">
                <label>Mini-título (Eyebrow)</label>
                <input type="text" name="prob_eyebrow" value="<?php echo htmlspecialchars($home['problem_solution']['prob_eyebrow'] ?? 'O Problema'); ?>">
              </div>
              <div class="form-group">
                <label>Título do Bloco</label>
                <input type="text" name="prob_title" value="<?php echo htmlspecialchars($home['problem_solution']['prob_title'] ?? ''); ?>">
              </div>
              <div class="form-group">
                <label>Conteúdo (Parágrafos)</label>
                <textarea name="prob_body" style="min-height:150px;"><?php echo htmlspecialchars($home['problem_solution']['prob_body'] ?? ''); ?></textarea>
              </div>
            </div>

            <div class="sub-section" style="margin-bottom:0; border-left-color: var(--warm-gray);">
              <h3 class="sub-title">A Solução</h3>
              <div class="form-group">
                <label>Mini-título (Eyebrow)</label>
                <input type="text" name="sol_eyebrow" value="<?php echo htmlspecialchars($home['problem_solution']['sol_eyebrow'] ?? 'A Solução'); ?>">
              </div>
              <div class="form-group">
                <label>Título do Bloco</label>
                <input type="text" name="sol_title" value="<?php echo htmlspecialchars($home['problem_solution']['sol_title'] ?? ''); ?>">
              </div>
              <div class="form-group">
                <label>Conteúdo (Parágrafos)</label>
                <textarea name="sol_body" style="min-height:150px;"><?php echo htmlspecialchars($home['problem_solution']['sol_body'] ?? ''); ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- SEÇÃO: SERVIÇOS (CARDS) -->
        <div class="card">
          <h2 class="section-title">4. Grade de Serviços</h2>
          
          <?php for ($i = 0; $i < 5; $i++): 
            $svc = $home['services'][$i] ?? ['label'=>'', 'title'=>'', 'tagline'=>'', 'body'=>''];
          ?>
            <div class="sub-section">
              <h3 class="sub-title">Serviço #<?php echo $i + 1; ?></h3>
              <div class="form-grid-three">
                <div class="form-group">
                  <label>Categoria (Ex: Tributário)</label>
                  <input type="text" name="svc_label_<?php echo $i; ?>" value="<?php echo htmlspecialchars($svc['label'] ?? ''); ?>">
                </div>
                <div class="form-group">
                  <label>Título do Serviço</label>
                  <input type="text" name="svc_title_<?php echo $i; ?>" value="<?php echo htmlspecialchars($svc['title'] ?? ''); ?>">
                </div>
                <div class="form-group">
                  <label>Frase de Efeito (Tagline)</label>
                  <input type="text" name="svc_tagline_<?php echo $i; ?>" value="<?php echo htmlspecialchars($svc['tagline'] ?? ''); ?>">
                </div>
              </div>
              <div class="form-group">
                <label>Descrição do Serviço</label>
                <textarea name="svc_body_<?php echo $i; ?>"><?php echo htmlspecialchars($svc['body'] ?? ''); ?></textarea>
              </div>
            </div>
          <?php endfor; ?>
        </div>

        <!-- SEÇÃO: POR QUE BRAVAU -->
        <div class="card">
          <h2 class="section-title">5. Por que Bravau (Diferenciais)</h2>
          
          <div class="form-grid">
            <div class="form-group">
              <label>Mini-título (Eyebrow)</label>
              <input type="text" name="why_eyebrow" value="<?php echo htmlspecialchars($home['why_bravau']['eyebrow'] ?? 'Por que Bravau'); ?>">
            </div>
            <div class="form-group">
              <label>Título da Seção</label>
              <input type="text" name="why_title" value="<?php echo htmlspecialchars($home['why_bravau']['title'] ?? ''); ?>">
            </div>
          </div>

          <div class="form-grid">
            <div class="form-group">
              <label>Número/Métrica Direita (Ex: +10)</label>
              <input type="text" name="why_metric_val" value="<?php echo htmlspecialchars($home['why_bravau']['metric_val'] ?? ''); ?>">
            </div>
            <div class="form-group">
              <label>Rótulo da Métrica Direita</label>
              <input type="text" name="why_metric_label" value="<?php echo htmlspecialchars($home['why_bravau']['metric_label'] ?? ''); ?>">
            </div>
          </div>

          <?php for ($i = 0; $i < 4; $i++): 
            $diff = $home['why_bravau']['differentials'][$i] ?? ['n'=>sprintf('%02d', $i+1), 'title'=>'', 'desc'=>''];
          ?>
            <div class="sub-section">
              <h3 class="sub-title">Diferencial <?php echo $diff['n']; ?></h3>
              <input type="hidden" name="diff_n_<?php echo $i; ?>" value="<?php echo htmlspecialchars($diff['n']); ?>">
              <div class="form-group">
                <label>Título do Diferencial</label>
                <input type="text" name="diff_title_<?php echo $i; ?>" value="<?php echo htmlspecialchars($diff['title'] ?? ''); ?>">
              </div>
              <div class="form-group">
                <label>Descrição</label>
                <textarea name="diff_desc_<?php echo $i; ?>"><?php echo htmlspecialchars($diff['desc'] ?? ''); ?></textarea>
              </div>
            </div>
          <?php endfor; ?>
        </div>

        <!-- SEÇÃO: QUEM SOMOS -->
        <div class="card">
          <h2 class="section-title">6. Seção Quem Somos</h2>
          
          <div class="form-grid">
            <div class="sub-section" style="margin-bottom:0;">
              <h3 class="sub-title">Coluna Esquerda (Institucional)</h3>
              <div class="form-group">
                <label>Mini-título (Eyebrow)</label>
                <input type="text" name="about_left_eyebrow" value="<?php echo htmlspecialchars($home['about']['left_eyebrow'] ?? 'Quem Somos'); ?>">
              </div>
              <div class="form-group">
                <label>Título Principal</label>
                <input type="text" name="about_left_title" value="<?php echo htmlspecialchars($home['about']['left_title'] ?? ''); ?>">
              </div>
              <div class="form-group">
                <label>Texto (Parágrafos)</label>
                <textarea name="about_left_body" style="min-height:150px;"><?php echo htmlspecialchars($home['about']['left_body'] ?? ''); ?></textarea>
              </div>
            </div>

            <div class="sub-section" style="margin-bottom:0;">
              <h3 class="sub-title">Coluna Direita (Diferencial)</h3>
              <div class="form-group">
                <label>Mini-título (Eyebrow)</label>
                <input type="text" name="about_right_eyebrow" value="<?php echo htmlspecialchars($home['about']['right_eyebrow'] ?? 'Diferencial'); ?>">
              </div>
              <div class="form-group">
                <label>Título Principal</label>
                <input type="text" name="about_right_title" value="<?php echo htmlspecialchars($home['about']['right_title'] ?? ''); ?>">
              </div>
              <div class="form-group">
                <label>Texto (Parágrafos)</label>
                <textarea name="about_right_body" style="min-height:150px;"><?php echo htmlspecialchars($home['about']['right_body'] ?? ''); ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- SEÇÃO: CHAMADA PARA AÇÃO (CTA) & RODAPÉ -->
        <div class="card">
          <h2 class="section-title">7. Chamada para Ação (CTA) & Contatos</h2>
          
          <div class="form-group">
            <label>Mini-título (Eyebrow)</label>
            <input type="text" name="cta_eyebrow" value="<?php echo htmlspecialchars($home['cta']['eyebrow'] ?? 'Próximo Passo'); ?>">
          </div>
          <div class="form-group">
            <label>Título Principal do Fechamento (Aceita quebra de linha)</label>
            <textarea name="cta_title"><?php echo htmlspecialchars($home['cta']['title'] ?? ''); ?></textarea>
          </div>
          <div class="form-group">
            <label>Texto de Apoio (Lead)</label>
            <textarea name="cta_lead"><?php echo htmlspecialchars($home['cta']['lead'] ?? ''); ?></textarea>
          </div>
          <div class="form-group">
            <label>Nota de Rodapé do Botão</label>
            <input type="text" name="cta_note" value="<?php echo htmlspecialchars($home['cta']['note'] ?? ''); ?>">
          </div>

          <div class="sub-section" style="margin-top:20px;">
            <h3 class="sub-title">Informações de Contato Físico</h3>
            <div class="form-grid-three">
              <div class="form-group">
                <label>E-mail de Contato</label>
                <input type="text" name="contact_email" value="<?php echo htmlspecialchars($home['contact']['email'] ?? ''); ?>">
              </div>
              <div class="form-group">
                <label>Telefone / WhatsApp (Débora)</label>
                <input type="text" name="contact_phone" value="<?php echo htmlspecialchars($home['contact']['phone'] ?? ''); ?>">
              </div>
              <div class="form-group">
                <label>Endereço / Cidade</label>
                <input type="text" name="contact_address" value="<?php echo htmlspecialchars($home['contact']['address'] ?? ''); ?>">
              </div>
            </div>
          </div>
        </div>

        <div style="margin-bottom:50px;">
          <button type="submit" name="save_content" class="btn" style="padding:15px 40px; font-size:13px;">Salvar Alterações do Site</button>
        </div>

      </form>
    <?php endif; ?>

  <?php endif; ?>

</div>

</body>
</html>
