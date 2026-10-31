<?php
/** @var string $contentHTML */
/** @var \Framework\Support\LinkGenerator $link */

// AI-assisted layout extracted from html/index.html and html/detail.html.
$isDetail = ($_GET['a'] ?? 'index') === 'detail';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Spr&aacute;va vozidiel - <?= $isDetail ? 'Detail vozidla' : 'Preh&#318;ad' ?></title>
  <link rel="stylesheet" href="<?= $link->asset('css/style.css') ?>">
</head>
<body>
  <div class="app">
    <aside class="sidebar">
      <div class="brand">
        <div class="brand-mark">SV</div>
        <span>Spr&aacute;va vozidiel</span>
      </div>

      <nav aria-label="Hlavn&aacute; navig&aacute;cia">
        <ul class="nav-list">
          <li><a class="nav-link<?= $isDetail ? '' : ' active' ?>" href="<?= $link->url('home.index') ?>">Preh&#318;ad</a></li>
          <li><a class="nav-link<?= $isDetail ? ' active' : '' ?>" href="<?= $link->url('home.detail') ?>">Moje vozidl&aacute;</a></li>
          <li><a class="nav-link" href="#">Servisn&aacute; hist&oacute;ria</a></li>
          <li><a class="nav-link" href="#">Tankovania</a></li>
          <li><a class="nav-link" href="#">Dokumenty</a></li>
        </ul>

        <div class="mobile-nav">
          <a class="<?= $isDetail ? '' : 'active' ?>" href="<?= $link->url('home.index') ?>">Preh&#318;ad</a>
          <a class="<?= $isDetail ? 'active' : '' ?>" href="<?= $link->url('home.detail') ?>">Vozidl&aacute;</a>
          <a href="#">Servis</a>
          <a href="#">Tankovania</a>
          <a href="#">Dokumenty</a>
        </div>
      </nav>

      <div class="sidebar-bottom">
        <a href="#">Administr&aacute;cia</a>
        <a href="#">Odhl&aacute;si&#357; sa</a>
      </div>
    </aside>

    <div class="app-body">
      <header class="topbar">
        <div class="topbar-title">Spr&aacute;va vozidiel</div>
        <div class="user">
          <div class="user-avatar" aria-hidden="true"></div>
          <span>Pou&#382;&iacute;vate&#318;</span>
        </div>
      </header>

      <main class="main">
        <?= $contentHTML ?>
      </main>
    </div>
  </div>
</body>
</html>
