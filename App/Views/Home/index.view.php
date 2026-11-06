<?php
/** @var \App\Models\Vozidlo[] $vozidla */
/** @var \Framework\Support\LinkGenerator $link */
// AI-assisted replacement of static placeholders with live vehicle data: ChatGPT, week 6.

$soon = 0;
foreach ($vozidla as $vehicle) {
    if ($vehicle->stk_do && $vehicle->stk_do >= date('Y-m-d')
        && $vehicle->stk_do <= date('Y-m-d', strtotime('+30 days'))) {
        $soon++;
    }
}
?>
<section class="page-heading">
  <div>
    <h1>Preh&#318;ad</h1>
    <p class="subtitle">S&uacute;hrn vozidiel a bl&iacute;&#382;iacich sa term&iacute;nov.</p>
  </div>
  <a class="btn btn-primary" href="<?= $link->url('vozidlo.create') ?>">+ Prida&#357; vozidlo</a>
</section>

<section class="panel overview-panel" aria-label="Preh&#318;ad aplik&aacute;cie">
  <div class="summary-grid">
    <article class="placeholder-card">
      <span class="muted">Po&#269;et vozidiel</span>
      <strong class="summary-number"><?= count($vozidla) ?></strong>
    </article>
    <article class="placeholder-card">
      <span class="muted">STK v nasleduj&uacute;cich 30 d&#328;och</span>
      <strong class="summary-number"><?= $soon ?></strong>
    </article>
    <article class="placeholder-card">
      <span class="muted">Najnov&#353;ie evidovan&eacute; vozidlo</span>
      <strong class="summary-title"><?= $vozidla ? htmlspecialchars($vozidla[0]->znacka . ' ' . $vozidla[0]->model, ENT_QUOTES, 'UTF-8') : '&mdash;' ?></strong>
    </article>
  </div>

  <div class="overview-content">
    <div class="page-heading">
      <h2>Moje vozidl&aacute;</h2>
      <a class="btn" href="<?= $link->url('vozidlo.index') ?>">Zobrazi&#357; v&#353;etky</a>
    </div>
    <?php if (!$vozidla): ?>
      <p>Zatia&#318; nie s&uacute; evidovan&eacute; &#382;iadne vozidl&aacute;.</p>
    <?php else: ?>
      <div class="overview-vehicle-list">
        <?php foreach (array_slice($vozidla, 0, 4) as $vehicle): ?>
          <a class="overview-vehicle" href="<?= $link->url('home.detail', ['id' => $vehicle->id]) ?>">
            <strong><?= htmlspecialchars($vehicle->znacka . ' ' . $vehicle->model, ENT_QUOTES, 'UTF-8') ?></strong>
            <span class="muted"><?= htmlspecialchars($vehicle->ecv, ENT_QUOTES, 'UTF-8') ?> &middot; <?= $vehicle->rok_vyroby ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
