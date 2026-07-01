<?php
$home = [];
if (file_exists('site_content.json')) {
    $home = json_decode(file_get_contents('site_content.json'), true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bravau Auditores — Audit · Accounting · Consulting</title>
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
      --gold-dim:    #6B5A2A;
      --white:       #FFFFFF;
      --off-white:   #F0EDE8;
      --warm-gray:   #9A9A8A;
    }

    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    html { scroll-behavior: smooth; }

    body {
      background: var(--deep-onyx);
      color: var(--off-white);
      font-family: "Inter", "Helvetica Neue", Arial, sans-serif;
      font-weight: 300;
      font-size: 17px;
      line-height: 1.7;
      -webkit-font-smoothing: antialiased;
    }

    /* ─── TYPOGRAPHY ─── */
    h1, h2, h3 {
      font-family: Georgia, "Times New Roman", serif;
      font-weight: 700;
      color: var(--white);
      letter-spacing: -0.02em;
    }
    h1 {
      line-height: 1.1;
    }
    h2 {
      line-height: 1.3;
    }
    h3 {
      line-height: 1.25;
    }

    .eyebrow {
      display: inline-block;
      font-family: "Inter", sans-serif;
      font-weight: 600;
      font-size: 10px;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      background: var(--gold);
      color: var(--deep-onyx);
      padding: 6px 16px;
      border-radius: 0;
      margin-bottom: 24px;
    }

    /* ─── LAYOUT ─── */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
    }

    section { padding: 100px 0; }

    /* ─── BUTTONS ─── */
    .btn-primary {
      display: inline-block;
      background: var(--gold);
      color: var(--deep-onyx);
      font-family: "Inter", sans-serif;
      font-weight: 600;
      font-size: 11px;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      padding: 14px 32px;
      border-radius: 0;
      border: none;
      text-decoration: none;
      cursor: pointer;
      transition: background 0.2s ease;
    }
    .btn-primary:hover { background: var(--gold-muted); }

    .btn-ghost {
      display: inline-block;
      background: transparent;
      border: 1px solid var(--gold);
      color: var(--gold);
      font-family: "Inter", sans-serif;
      font-weight: 600;
      font-size: 11px;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      padding: 14px 32px;
      border-radius: 0;
      text-decoration: none;
      cursor: pointer;
      transition: background 0.2s ease;
    }
    .btn-ghost:hover { background: rgba(201, 168, 76, 0.08); }

    /* ─── NAVIGATION ─── */
    nav {
      position: sticky;
      top: 0;
      z-index: 100;
      background: var(--deep-onyx);
      border-bottom: 1px solid rgba(201, 168, 76, 0.2);
    }

    .nav-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
      height: 72px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .logo-wrap { text-decoration: none; display: flex; align-items: center; }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 32px;
      list-style: none;
    }
    .nav-links a {
      font-family: "Inter", sans-serif;
      font-weight: 400;
      font-size: 14px;
      color: var(--off-white);
      text-decoration: none;
      letter-spacing: 0.05em;
      transition: color 0.2s;
    }
    .nav-links a:hover { color: var(--gold); }
    .nav-links .nav-cta { padding: 10px 24px; }

    /* ─── HERO ─── */
    .hero {
      position: relative;
      padding: 160px 0 140px;
      background: linear-gradient(135deg, rgba(26, 26, 26, 0.92) 20%, rgba(26, 26, 26, 0.65) 100%), url('bravau_hero_bg.jpg') no-repeat center center;
      background-size: cover;
      overflow: hidden;
      border-bottom: 1px solid rgba(201, 168, 76, 0.2);
    }

    .hero-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
      display: grid;
      grid-template-columns: 55fr 45fr;
      gap: 64px;
      align-items: center;
    }

    .hero h1 {
      font-size: clamp(38px, 5vw, 66px);
      line-height: 1.05;
      margin-bottom: 28px;
    }

    .hero-lead {
      font-family: Georgia, "Times New Roman", serif;
      font-weight: 400;
      font-style: italic;
      font-size: 19px;
      color: var(--off-white);
      line-height: 1.5;
      margin-bottom: 40px;
    }

    .hero-ctas { display: flex; gap: 16px; flex-wrap: wrap; align-items: center; }

    .hero-cert {
      margin-top: 48px;
      padding-top: 24px;
      border-top: 1px solid rgba(201, 168, 76, 0.3);
      font-family: "Inter", sans-serif;
      font-weight: 300;
      font-size: 12px;
      color: var(--warm-gray);
      letter-spacing: 0.1em;
    }

    /* Concentric diamond motif */
    .hero-visual {
      position: relative;
      height: 440px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .hero-visual .hero-kpi {
      background: rgba(26, 26, 26, 0.85);
      border: 1px solid var(--gold);
      padding: 32px 40px;
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      text-align: center;
      width: 260px;
    }

    .diamonds {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 0;
      height: 0;
    }

    .diamond {
      position: absolute;
      border: 1px solid var(--gold-dim);
      transform: translate(-50%, -50%) rotate(45deg);
    }
    .diamond:nth-child(1) { width:  70px; height:  70px; opacity: 0.75; border-color: var(--gold); }
    .diamond:nth-child(2) { width: 130px; height: 130px; opacity: 0.65; }
    .diamond:nth-child(3) { width: 190px; height: 190px; opacity: 0.55; }
    .diamond:nth-child(4) { width: 255px; height: 255px; opacity: 0.45; }
    .diamond:nth-child(5) { width: 320px; height: 320px; opacity: 0.35; }
    .diamond:nth-child(6) { width: 385px; height: 385px; opacity: 0.25; }
    .diamond:nth-child(7) { width: 450px; height: 450px; opacity: 0.15; }

    .hero-kpi {
      position: relative;
      z-index: 2;
      text-align: center;
    }
    .hero-kpi-num {
      font-family: Georgia, serif;
      font-weight: 700;
      font-size: 88px;
      color: var(--gold);
      line-height: 1;
      display: block;
    }
    .hero-kpi-label {
  font-family: 'Inter', sans-serif;
  font-weight: 500;
  font-size: 13px;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: #C9A84C;
  line-height: 1.6;
}

    /* ─── TOP CREDENTIALS BANNER ─── */
    .top-banner {
      background: #222222;
      border-bottom: 1px solid rgba(201, 168, 76, 0.3);
      padding: 12px 24px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      gap: 6px 12px;
      text-align: center;
    }
    .top-banner-title {
      font-family: 'Inter', sans-serif;
      font-weight: 500;
      font-size: 13px;
      letter-spacing: 0.18em;
      color: #C9A84C;
      text-transform: uppercase;
    }
    .top-banner-divider {
      font-family: 'Inter', sans-serif;
      font-weight: 300;
      font-size: 13px;
      color: #9A9A8A;
    }
    .top-banner-standards {
      font-family: 'Inter', sans-serif;
      font-weight: 300;
      font-size: 13px;
      letter-spacing: 0.1em;
      color: #9A9A8A;
      text-transform: uppercase;
    }
    @media (max-width: 600px) {
      .top-banner {
        flex-direction: column;
        gap: 4px;
        padding: 10px 16px;
      }
      .top-banner-divider {
        display: none;
      }
    }

    /* ─── CREDENTIALS BAR ─── */
    .cred-bar {
      background: var(--charcoal);
      border-top: 1px solid rgba(201, 168, 76, 0.25);
      border-bottom: 1px solid rgba(201, 168, 76, 0.25);
      padding: 20px 24px;
      text-align: center;
    }
    .cred-bar p {
      font-family: "Inter", sans-serif;
      font-weight: 300;
      font-size: 12px;
      color: var(--warm-gray);
      letter-spacing: 0.12em;
      text-transform: uppercase;
    }

    /* ─── METRICS ─── */
    .metrics-section {
      background: var(--deep-onyx);
      border-bottom: 1px solid rgba(201, 168, 76, 0.12);
    }

    .section-header { margin-bottom: 72px; }
    .section-header h2 { font-size: clamp(30px, 4vw, 50px); }

    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 0;
    }

    .metric-item {
      padding: 0 48px 0 0;
    }
    .metric-item + .metric-item {
      padding-left: 48px;
      border-left: 1px solid rgba(201, 168, 76, 0.2);
    }

    .metric-num {
      font-family: Georgia, serif;
      font-weight: 700;
      font-size: 64px;
      color: var(--gold);
      line-height: 1;
      display: block;
    }
    .metric-lbl {
      font-family: "Inter", sans-serif;
      font-weight: 600;
      font-size: 11px;
      color: var(--warm-gray);
      letter-spacing: 0.1em;
      text-transform: uppercase;
      margin-top: 12px;
      display: block;
    }
    .metric-desc {
      font-size: 15px;
      color: var(--off-white);
      margin-top: 14px;
      line-height: 1.6;
    }

    /* ─── PROBLEM / SOLUTION ─── */
    .problem-section { background: var(--charcoal); }

    .two-col {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: start;
    }

    .col-divider { border-left: 1px solid rgba(201, 168, 76, 0.3); padding-left: 80px; }

    .section-h2 {
      font-size: clamp(26px, 3.2vw, 42px);
      margin-bottom: 24px;
      line-height: 1.3;
    }

    .body-p {
      font-size: 17px;
      color: var(--off-white);
      line-height: 1.7;
      margin-bottom: 16px;
    }

    /* ─── SERVICES ─── */
    .services-section { background: var(--deep-onyx); }

    .services-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 24px;
    }

    .svc-card {
      background: var(--charcoal);
      border-top: 3px solid var(--gold);
      border-radius: 0;
      padding: 40px 32px;
      transition: background 0.2s ease;
      grid-column: span 2;
    }
    .svc-card:hover { background: var(--surface-dark); }

    .svc-card:nth-child(4) { grid-column: span 3; }
    .svc-card:nth-child(5) { grid-column: span 3; }

    .svc-label {
      font-family: "Inter", sans-serif;
      font-weight: 600;
      font-size: 10px;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 16px;
    }
    .svc-title {
      font-family: Georgia, serif;
      font-weight: 700;
      font-size: 22px;
      color: var(--white);
      letter-spacing: -0.02em;
      line-height: 1.2;
      margin-bottom: 14px;
    }
    .svc-tagline {
      font-family: Georgia, serif;
      font-style: italic;
      font-size: 15px;
      color: var(--off-white);
      margin-bottom: 18px;
      line-height: 1.5;
    }
    .svc-body {
      font-size: 15px;
      color: var(--warm-gray);
      line-height: 1.7;
    }

    /* ─── WHY BRAVAU ─── */
    .why-section {
      background: var(--charcoal);
      overflow: hidden;
    }

    .why-inner {
      display: grid;
      grid-template-columns: 55fr 45fr;
      gap: 80px;
      align-items: center;
    }

    .why-list { list-style: none; margin-top: 36px; }

    .why-item {
      display: flex;
      align-items: flex-start;
      gap: 20px;
      padding: 24px 0;
      border-bottom: 1px solid rgba(201, 168, 76, 0.15);
    }
    .why-item:first-child { border-top: 1px solid rgba(201, 168, 76, 0.15); }

    .why-n {
      font-family: Georgia, serif;
      font-weight: 700;
      font-size: 28px;
      color: var(--gold);
      line-height: 1;
      min-width: 36px;
      padding-top: 2px;
    }

    .why-content h3 {
      font-size: 18px;
      margin-bottom: 6px;
      line-height: 1.3;
    }
    .why-content p {
      font-size: 15px;
      color: var(--warm-gray);
      line-height: 1.6;
    }

    .why-visual {
      position: relative;
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .why-kpi {
      position: relative;
      z-index: 2;
      text-align: center;
    }
    .why-kpi span:first-child {
      font-family: Georgia, serif;
      font-weight: 700;
      font-size: 72px;
      color: var(--gold);
      display: block;
      line-height: 1;
    }
    .why-kpi span:last-child {
      font-family: "Inter", sans-serif;
      font-weight: 300;
      font-size: 13px;
      color: var(--warm-gray);
      letter-spacing: 0.1em;
      text-transform: uppercase;
      margin-top: 10px;
      display: block;
    }

    /* ─── FINAL CTA ─── */
    .cta-section {
      background: var(--deep-onyx);
      text-align: center;
    }

    .cta-section h2 {
      font-size: clamp(30px, 4vw, 54px);
      margin-bottom: 24px;
    }

    .cta-lead {
      font-family: Georgia, serif;
      font-style: italic;
      font-size: 19px;
      color: var(--off-white);
      margin-bottom: 48px;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      line-height: 1.5;
    }

    .cta-btns { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; }

    .cta-note {
      margin-top: 32px;
      font-family: "Inter", sans-serif;
      font-weight: 300;
      font-size: 13px;
      color: var(--warm-gray);
      letter-spacing: 0.05em;
    }

    /* ─── FOOTER ─── */
    footer {
      background: var(--charcoal);
      border-top: 1px solid rgba(201, 168, 76, 0.3);
      padding: 64px 0 40px;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: 1.4fr 1fr 1fr;
      gap: 48px;
      margin-bottom: 48px;
    }

    .footer-brand p {
      font-size: 14px;
      color: var(--warm-gray);
      line-height: 1.6;
      margin-top: 14px;
    }

    .footer-col h4 {
      font-family: "Inter", sans-serif;
      font-weight: 600;
      font-size: 11px;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 20px;
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

    /* ─── BLOG ─── */
    .blog-section { background: var(--charcoal); }
    .blog-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 32px;
    }
    .blog-card {
      background: var(--deep-onyx);
      border-top: 3px solid var(--gold);
      padding: 32px 24px;
      display: flex;
      flex-direction: column;
      height: 100%;
      transition: background 0.2s ease;
    }
    .blog-card:hover {
      background: var(--surface-dark);
    }
    .blog-date {
      font-family: 'Inter', sans-serif;
      font-weight: 500;
      font-size: 11px;
      color: var(--gold);
      letter-spacing: 0.1em;
      text-transform: uppercase;
      margin-bottom: 12px;
    }
    .blog-title {
      font-family: Georgia, serif;
      font-weight: 700;
      font-size: 20px;
      color: var(--white);
      line-height: 1.3;
      margin-bottom: 16px;
    }
    .blog-excerpt {
      font-family: 'Inter', sans-serif;
      font-size: 15px;
      color: var(--warm-gray);
      line-height: 1.6;
      margin-bottom: 24px;
      flex-grow: 1;
    }
    .blog-link {
      font-family: 'Inter', sans-serif;
      font-weight: 600;
      font-size: 12px;
      color: var(--gold);
      text-decoration: none;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    .blog-link:hover {
      color: var(--off-white);
    }


    /* ─── FADE-IN ANIMATION ─── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.65s ease both; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 960px) {
      .hero-inner      { grid-template-columns: 1fr; }
      .hero-visual     { display: flex; height: 350px; margin-top: 32px; }
      .two-col         { grid-template-columns: 1fr; gap: 48px; }
      .col-divider     { border-left: none; padding-left: 0; border-top: 1px solid rgba(201, 168, 76, 0.3); padding-top: 48px; }
      .metrics-grid    { grid-template-columns: 1fr; gap: 40px; }
      .metric-item     { padding: 0; }
      .metric-item + .metric-item { padding-left: 0; border-left: none; border-top: 1px solid rgba(201, 168, 76, 0.2); padding-top: 40px; }
      .services-grid   { grid-template-columns: 1fr; }
      .svc-card, .svc-card:nth-child(4), .svc-card:nth-child(5) { grid-column: span 1; }
      .why-inner       { grid-template-columns: 1fr; }
      .why-visual      { display: none; }
      .blog-grid       { grid-template-columns: 1fr; gap: 24px; }
      .footer-grid     { grid-template-columns: 1fr; }
    }

    /* ─── MENU HAMBÚRGUER (DESKTOP DEFAULT) ─── */
    .menu-btn {
      display: none;
      flex-direction: column;
      justify-content: space-between;
      width: 24px;
      height: 18px;
      cursor: pointer;
      z-index: 110;
    }
    .menu-btn span {
      display: block;
      width: 100%;
      height: 2px;
      background-color: var(--gold);
      transition: all 0.3s ease;
    }

    @media (max-width: 600px) {
      section          { padding: 72px 0; }
      .hero            { padding: 80px 0 64px; }
      .metric-num      { font-size: 48px; }
      .hero-visual     { height: 280px; }
      .hero-visual .hero-kpi { padding: 16px 24px; width: 190px; }
      .hero-kpi-num    { font-size: 64px; }

      /* Responsividade do Menu Mobile */
      .menu-btn {
        display: flex;
      }

      .nav-inner {
        position: relative;
      }

      .nav-links {
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 72px;
        left: 0;
        width: 100%;
        background: var(--deep-onyx);
        border-bottom: 1px solid rgba(201, 168, 76, 0.2);
        padding: 32px 24px;
        gap: 24px;
        align-items: stretch;
        text-align: center;
        
        /* Estado inicial oculto com transição suave */
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease;
        z-index: 99;
      }

      .nav-links .nav-cta {
        padding: 14px 32px; /* Restaura padding padrão do botão primário no mobile */
      }

      /* Alternância de estado via Checkbox */
      .menu-toggle-cb:checked ~ .nav-links {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
      }

      /* Transição do ícone Hambúrguer para X */
      .menu-toggle-cb:checked ~ .menu-btn span:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
      }
      .menu-toggle-cb:checked ~ .menu-btn span:nth-child(2) {
        opacity: 0;
      }
      .menu-toggle-cb:checked ~ .menu-btn span:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
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
      <a href="#" class="logo-wrap">
        <img src="Logo Bravau.png" alt="Bravau Auditores" height="48" style="height:48px;width:auto;display:block;">
      </a>

      <!-- Controle de estado do Menu (Checkbox Hack) -->
      <input type="checkbox" id="menu-toggle" class="menu-toggle-cb" style="display: none;">

      <!-- Ícone Hambúrguer -->
      <label for="menu-toggle" class="menu-btn">
        <span></span>
        <span></span>
        <span></span>
      </label>

      <ul class="nav-links">
        <li><a href="#quem-somos" onclick="document.getElementById('menu-toggle').checked = false">Quem Somos</a></li>
        <li><a href="#servicos" onclick="document.getElementById('menu-toggle').checked = false">Serviços</a></li>
        <li><a href="#diferenciais" onclick="document.getElementById('menu-toggle').checked = false">Por que Bravau</a></li>
        <li><a href="#resultados" onclick="document.getElementById('menu-toggle').checked = false">Resultados</a></li>
        <li><a href="blog.php" onclick="document.getElementById('menu-toggle').checked = false">Blog</a></li>
        <li><a href="https://wa.me/5562<?php echo preg_replace('/\D/', '', $home['contact']['phone'] ?? ''); ?>?text=Olá,%20gostaria%20de%20falar%20com%20um%20especialista%20da%20Bravau." target="_blank" class="btn-primary nav-cta" onclick="document.getElementById('menu-toggle').checked = false">Fale com um especialista</a></li>
      </ul>
    </div>
  </nav>
<div class="top-banner">
  <span class="top-banner-title"><?php echo htmlspecialchars($home['top_banner']['title'] ?? ''); ?></span>
  <span class="top-banner-divider">·</span>
  <span class="top-banner-standards"><?php echo htmlspecialchars($home['top_banner']['standards'] ?? ''); ?></span>
</div>

  <!-- ═══════════════════════════════
       HERO
  ═══════════════════════════════ -->
  <section class="hero">
    <div class="hero-inner">

      <div class="hero-content fade-up">
        <span class="eyebrow">Do ponto A ao ponto B</span>
        <h1><?php echo nl2br(htmlspecialchars($home['hero']['title'] ?? '')); ?></h1>
        <p class="hero-lead">
          <?php echo htmlspecialchars($home['hero']['lead'] ?? ''); ?>
        </p>
        <div class="hero-ctas">
          <a href="https://wa.me/5562<?php echo preg_replace('/\D/', '', $home['contact']['phone'] ?? ''); ?>?text=Olá,%20gostaria%20de%20falar%20com%20um%20especialista%20da%20Bravau." target="_blank" class="btn-primary">Diagnóstico sem compromisso</a>
          <a href="#servicos" class="btn-ghost">Conheça os serviços</a>
        </div>
        <p class="hero-cert">
          <?php echo htmlspecialchars($home['top_banner']['title'] ?? '') . ' &nbsp;·&nbsp; ' . htmlspecialchars($home['top_banner']['standards'] ?? ''); ?>
        </p>
      </div>

      <div class="hero-visual">
        <div class="hero-kpi">
          <span class="hero-kpi-num">$</span>
          <span class="hero-kpi-label"><?php echo nl2br(htmlspecialchars($home['hero']['kpi_label'] ?? '')); ?></span>
        </div>
      </div>

    </div>
  </section>

<div style="width:100%; height:1px; background:linear-gradient(to right, transparent, #C9A84C, transparent); opacity:0.4;"></div>
  


  <!-- ═══════════════════════════════
       METRICS
  ═══════════════════════════════ -->
  <section class="metrics-section" id="resultados">
    <div class="container">
      <div class="section-header">
        <span class="eyebrow">Resultados Comprovados</span>
        <h2>O que entregamos, em números.</h2>
      </div>
      <div class="metrics-grid">
        <div class="metric-item">
          <span class="metric-num"><?php echo htmlspecialchars($home['metrics']['m1_val'] ?? ''); ?></span>
          <span class="metric-lbl"><?php echo htmlspecialchars($home['metrics']['m1_label'] ?? ''); ?></span>
          <p class="metric-desc"><?php echo htmlspecialchars($home['metrics']['m1_desc'] ?? ''); ?></p>
        </div>
        <div class="metric-item">
          <span class="metric-num"><?php echo htmlspecialchars($home['metrics']['m2_val'] ?? ''); ?></span>
          <span class="metric-lbl"><?php echo htmlspecialchars($home['metrics']['m2_label'] ?? ''); ?></span>
          <p class="metric-desc"><?php echo htmlspecialchars($home['metrics']['m2_desc'] ?? ''); ?></p>
        </div>
        <div class="metric-item">
          <span class="metric-num"><?php echo htmlspecialchars($home['metrics']['m3_val'] ?? ''); ?></span>
          <span class="metric-lbl"><?php echo htmlspecialchars($home['metrics']['m3_label'] ?? ''); ?></span>
          <p class="metric-desc"><?php echo htmlspecialchars($home['metrics']['m3_desc'] ?? ''); ?></p>
        </div>
      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════
       PROBLEM / SOLUTION
  ═══════════════════════════════ -->
  <section class="problem-section">
    <div class="container">
      <div class="two-col">

        <div>
          <span class="eyebrow"><?php echo htmlspecialchars($home['problem_solution']['prob_eyebrow'] ?? 'O Problema'); ?></span>
          <h2 class="section-h2"><?php echo htmlspecialchars($home['problem_solution']['prob_title'] ?? ''); ?></h2>
          <?php 
          $paragraphs = explode("\n", $home['problem_solution']['prob_body'] ?? '');
          foreach ($paragraphs as $p) {
              $p = trim($p);
              if ($p !== '') echo '<p class="body-p">' . htmlspecialchars($p) . '</p>';
          }
          ?>
        </div>

        <div class="col-divider">
          <span class="eyebrow"><?php echo htmlspecialchars($home['problem_solution']['sol_eyebrow'] ?? 'A Solução'); ?></span>
          <h2 class="section-h2"><?php echo htmlspecialchars($home['problem_solution']['sol_title'] ?? ''); ?></h2>
          <?php 
          $paragraphs = explode("\n", $home['problem_solution']['sol_body'] ?? '');
          foreach ($paragraphs as $p) {
              $p = trim($p);
              if ($p !== '') echo '<p class="body-p">' . htmlspecialchars($p) . '</p>';
          }
          ?>
          <a href="https://wa.me/5562<?php echo preg_replace('/\D/', '', $home['contact']['phone'] ?? ''); ?>?text=Olá,%20gostaria%20de%20falar%20com%20um%20especialista%20da%20Bravau." target="_blank" class="btn-primary" style="margin-top: 28px;">A conversa é gratuita.</a>
        </div>

      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════
       SERVICES
  ═══════════════════════════════ -->
  <section class="services-section" id="servicos">
    <div class="container">
      <div class="section-header">
        <span class="eyebrow">O que fazemos</span>
        <h2>Cinco serviços. Uma empresa.</h2>
      </div>
      <div class="services-grid">
        <?php if (!empty($home['services'])): foreach ($home['services'] as $svc): ?>
        <div class="svc-card">
          <p class="svc-label"><?php echo htmlspecialchars($svc['label'] ?? ''); ?></p>
          <h3 class="svc-title"><?php echo htmlspecialchars($svc['title'] ?? ''); ?></h3>
          <p class="svc-tagline">"<?php echo htmlspecialchars($svc['tagline'] ?? ''); ?>"</p>
          <p class="svc-body"><?php echo htmlspecialchars($svc['body'] ?? ''); ?></p>
        </div>
        <?php endforeach; endif; ?>
      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════
       WHY BRAVAU
  ═══════════════════════════════ -->
  <section class="why-section" id="diferenciais">
    <div class="container">
      <div class="why-inner">

        <div>
          <span class="eyebrow"><?php echo htmlspecialchars($home['why_bravau']['eyebrow'] ?? 'Por que Bravau'); ?></span>
          <h2 class="section-h2"><?php echo htmlspecialchars($home['why_bravau']['title'] ?? ''); ?></h2>
          <ul class="why-list">
            <?php if (!empty($home['why_bravau']['differentials'])): foreach ($home['why_bravau']['differentials'] as $diff): ?>
            <li class="why-item">
              <span class="why-n"><?php echo htmlspecialchars($diff['n'] ?? ''); ?></span>
              <div class="why-content">
                <h3><?php echo htmlspecialchars($diff['title'] ?? ''); ?></h3>
                <p><?php echo htmlspecialchars($diff['desc'] ?? ''); ?></p>
              </div>
            </li>
            <?php endforeach; endif; ?>
          </ul>
        </div>

        <div class="why-visual">
          <div class="diamonds">
            <div class="diamond"></div>
            <div class="diamond"></div>
            <div class="diamond"></div>
            <div class="diamond"></div>
            <div class="diamond"></div>
          </div>
          <div class="why-kpi">
            <span><?php echo htmlspecialchars($home['why_bravau']['metric_val'] ?? ''); ?></span>
            <span><?php echo nl2br(htmlspecialchars($home['why_bravau']['metric_label'] ?? '')); ?></span>
          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════
       QUEM SOMOS
  ═══════════════════════════════ -->
  <section class="about-section" id="quem-somos">
    <div class="container">
      <div class="two-col">
        <div>
          <span class="eyebrow"><?php echo htmlspecialchars($home['about']['left_eyebrow'] ?? 'Quem Somos'); ?></span>
          <h2 class="section-h2"><?php echo htmlspecialchars($home['about']['left_title'] ?? ''); ?></h2>
          <?php 
          $paragraphs = explode("\n", $home['about']['left_body'] ?? '');
          foreach ($paragraphs as $p) {
              $p = trim($p);
              if ($p !== '') echo '<p class="body-p">' . htmlspecialchars($p) . '</p>';
          }
          ?>
        </div>
        <div class="col-divider">
          <span class="eyebrow"><?php echo htmlspecialchars($home['about']['right_eyebrow'] ?? 'Diferencial'); ?></span>
          <h2 class="section-h2"><?php echo htmlspecialchars($home['about']['right_title'] ?? ''); ?></h2>
          <?php 
          $paragraphs = explode("\n", $home['about']['right_body'] ?? '');
          foreach ($paragraphs as $p) {
              $p = trim($p);
              if ($p !== '') echo '<p class="body-p">' . htmlspecialchars($p) . '</p>';
          }
          ?>

        </div>
      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════
       BLOG
  ═══════════════════════════════ -->
  <section class="blog-section" id="blog">
    <div class="container">
      <div class="section-header">
        <span class="eyebrow">Artigos & Insights</span>
        <h2>Conhecimento que gera valor contábil.</h2>
      </div>
      <div class="blog-grid" id="blog-posts-container">
        <!-- Cards de blog serão inseridos dinamicamente aqui -->
      </div>
      <div style="text-align: center; margin-top: 48px;">
        <a href="blog.php" class="btn-primary" style="display: inline-block;">Ver todos os artigos</a>
      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════
       FINAL CTA
  ═══════════════════════════════ -->
  <section class="cta-section" id="contato">
    <div class="container">
      <span class="eyebrow"><?php echo htmlspecialchars($home['cta']['eyebrow'] ?? 'Próximo Passo'); ?></span>
      <h2><?php echo nl2br(htmlspecialchars($home['cta']['title'] ?? '')); ?></h2>
      <p class="cta-lead"><?php echo htmlspecialchars($home['cta']['lead'] ?? ''); ?></p>
      <div class="cta-btns">
        <a href="https://wa.me/5562<?php echo preg_replace('/\D/', '', $home['contact']['phone'] ?? ''); ?>?text=Olá,%20gostaria%20de%20falar%20com%20um%20especialista%20da%20Bravau." target="_blank" class="btn-primary">Fale no WhatsApp</a>
      </div>
      <p class="cta-note"><?php echo htmlspecialchars($home['cta']['note'] ?? ''); ?></p>
    </div>
  </section>


  <!-- ═══════════════════════════════
       FOOTER
  ═══════════════════════════════ -->
  <footer>
    <div class="container">
      <div class="footer-grid">

        <div class="footer-brand">
          <img src="Logo Bravau.png" alt="Bravau Auditores" height="48" style="height:48px;width:auto;display:block;margin-bottom:10px;">
          <p>Padrão Big Four para o mercado brasileiro de médio porte. Certificados, comprometidos, rastreáveis.</p>
        </div>

        <div class="footer-col">
          <h4>Serviços</h4>
          <ul>
            <?php if (!empty($home['services'])): foreach ($home['services'] as $svc): ?>
            <li><a href="#servicos"><?php echo htmlspecialchars($svc['title'] ?? ''); ?></a></li>
            <?php endforeach; endif; ?>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Contato</h4>
          <ul>
            <li><a href="mailto:<?php echo htmlspecialchars($home['contact']['email'] ?? ''); ?>"><?php echo htmlspecialchars($home['contact']['email'] ?? ''); ?></a></li>
            <li><a href="https://wa.me/5562<?php echo preg_replace('/\D/', '', $home['contact']['phone'] ?? ''); ?>" target="_blank">WhatsApp: <?php echo htmlspecialchars($home['contact']['phone'] ?? ''); ?></a></li>
            <li><a href="#"><?php echo htmlspecialchars($home['contact']['address'] ?? ''); ?></a></li>
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

  <!-- Scripts para Blog e Roteamento -->
  <script>
    let blogPosts = [];

    // Carrega os posts do JSON
    function loadBlogPosts() {
      fetch('blog.json')
        .then(response => response.json())
        .then(data => {
          blogPosts = data;
          renderBlogGrid();
        })
        .catch(err => console.error("Erro ao carregar blog:", err));
    }

    // Renderiza os 3 posts mais recentes no grid com detecção de localhost para fallback
    function renderBlogGrid() {
      const container = document.getElementById('blog-posts-container');
      if (!container) return;
      
      const isLocalhost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
      
      // Mostrar apenas os 3 posts mais recentes na home
      const recentPosts = blogPosts.slice(0, 3);
      
      container.innerHTML = recentPosts.map(post => {
        // Fallback local caso o servidor de desenvolvimento não suporte mod_rewrite (.htaccess)
        const postUrl = isLocalhost ? `post.php?slug=${post.slug}` : `artigo/${post.slug}`;
        
        return `
          <div class="blog-card" style="background-image: linear-gradient(rgba(26, 26, 26, 0.9), rgba(26, 26, 26, 0.95)), url('${post.image}'); background-size: cover; background-position: center;">
            <span class="blog-date">${post.date}</span>
            <h3 class="blog-title">${post.title}</h3>
            <p class="blog-excerpt">${post.excerpt}</p>
            <a href="${postUrl}" class="blog-link">Ler artigo →</a>
          </div>
        `;
      }).join('');
    }

    // Inicia o carregamento dinâmico
    window.addEventListener('DOMContentLoaded', loadBlogPosts);
  </script>

</body>
</html>
