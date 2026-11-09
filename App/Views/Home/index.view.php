<?php
/** @var \App\Models\Vozidlo[] $vozidla */
/** @var \App\Models\ServisnyZaznam[] $servisneZaznamy */
/** @var \App\Models\Tankovanie[] $tankovania */
/** @var \Framework\Support\LinkGenerator $link */
// AI-assisted replacement of static placeholders with live vehicle data: ChatGPT, week 6.

$h = static fn (mixed $value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
$nazvyVozidiel = [];
foreach ($vozidla as $vehicle) {
    $nazvyVozidiel[$vehicle->id] = $vehicle->znacka . ' ' . $vehicle->model;
}
$servisneNaklady = array_reduce($servisneZaznamy, static fn (float $sum, $item): float => $sum + (float) $item->cena, 0.0);
$palivoveNaklady = array_reduce($tankovania, static fn (float $sum, $item): float => $sum + (float) $item->mnozstvo_l * (float) $item->cena_za_liter, 0.0);
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
      <span class="muted">Náklady na servis a palivo</span>
      <strong class="summary-number"><?= number_format($servisneNaklady + $palivoveNaklady, 2, ',', ' ') ?> €</strong>
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

<section class="overview-activity" aria-label="Posledné udalosti">
  <article class="panel activity-panel">
    <div class="activity-heading">
      <h2>Posledné servisy</h2>
      <a class="btn btn-small" href="<?= $link->url('servis.create') ?>">+ Servis</a>
    </div>
    <?php if (!$servisneZaznamy): ?>
      <p class="muted">Zatiaľ nemáš žiadne servisné záznamy.</p>
    <?php else: ?>
      <?php foreach (array_slice($servisneZaznamy, 0, 3) as $item): ?>
        <div class="activity-row">
          <div>
            <strong><?= $h($item->nazov_ukonu) ?></strong>
            <span class="muted"><?= $h($nazvyVozidiel[$item->vozidlo_id] ?? 'Vozidlo') ?> · <?= date('d. m. Y', strtotime($item->datum_servisu)) ?></span>
          </div>
          <strong><?= number_format((float) $item->cena, 2, ',', ' ') ?> €</strong>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <a class="activity-all" href="<?= $link->url('servis.index') ?>">Všetky servisné záznamy</a>
  </article>

  <article class="panel activity-panel">
    <div class="activity-heading">
      <h2>Posledné tankovania</h2>
      <a class="btn btn-small" href="<?= $link->url('tankovanie.create') ?>">+ Tankovanie</a>
    </div>
    <?php if (!$tankovania): ?>
      <p class="muted">Zatiaľ nemáš zaevidované tankovania.</p>
    <?php else: ?>
      <?php foreach (array_slice($tankovania, 0, 3) as $item): ?>
        <div class="activity-row">
          <div>
            <strong><?= $h($nazvyVozidiel[$item->vozidlo_id] ?? 'Vozidlo') ?></strong>
            <span class="muted"><?= date('d. m. Y', strtotime($item->datum_tankovania)) ?> · <?= number_format((float) $item->mnozstvo_l, 2, ',', ' ') ?> l</span>
          </div>
          <strong><?= number_format((float) $item->mnozstvo_l * (float) $item->cena_za_liter, 2, ',', ' ') ?> €</strong>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <a class="activity-all" href="<?= $link->url('tankovanie.index') ?>">Všetky tankovania</a>
  </article>
</section>
