<?php
/** @var string $contentHTML */
/** @var \Framework\Support\LinkGenerator $link */

// AI-assisted update of the shared layout: ChatGPT, VAII assignment 6.
$controller = strtolower((string) ($_GET['c'] ?? 'home'));
$action = strtolower((string) ($_GET['a'] ?? 'index'));
$isVehiclePage = $controller === 'vozidlo' || ($controller === 'home' && $action === 'detail');
$isServicePage = $controller === 'servis';
$isFuelPage = $controller === 'tankovanie';
$isOverviewPage = !$isVehiclePage && !$isServicePage && !$isFuelPage;
$pageTitle = $isFuelPage ? 'Tankovania' : ($isServicePage ? 'Servisná história' : ($action === 'detail' ? 'Detail vozidla' : ($isVehiclePage ? 'Moje vozidlá' : 'Prehľad')));
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Spr&aacute;va vozidiel - <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
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
          <li><a class="nav-link<?= $isOverviewPage ? ' active' : '' ?>" href="<?= $link->url('home.index') ?>">Preh&#318;ad</a></li>
          <li><a class="nav-link<?= $isVehiclePage ? ' active' : '' ?>" href="<?= $link->url('vozidlo.index') ?>">Moje vozidl&aacute;</a></li>
          <li><a class="nav-link<?= $isServicePage ? ' active' : '' ?>" href="<?= $link->url('servis.index') ?>">Servisn&aacute; hist&oacute;ria</a></li>
          <li><a class="nav-link<?= $isFuelPage ? ' active' : '' ?>" href="<?= $link->url('tankovanie.index') ?>">Tankovania</a></li>
          <li><span class="nav-link nav-disabled" aria-disabled="true">Dokumenty</span></li>
        </ul>

        <div class="mobile-nav">
          <a class="<?= $isOverviewPage ? 'active' : '' ?>" href="<?= $link->url('home.index') ?>">Preh&#318;ad</a>
          <a class="<?= $isVehiclePage ? 'active' : '' ?>" href="<?= $link->url('vozidlo.index') ?>">Vozidl&aacute;</a>
          <a class="<?= $isServicePage ? 'active' : '' ?>" href="<?= $link->url('servis.index') ?>">Servis</a>
          <a class="<?= $isFuelPage ? 'active' : '' ?>" href="<?= $link->url('tankovanie.index') ?>">Tankovania</a>
          <span class="nav-disabled" aria-disabled="true">Dokumenty</span>
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
