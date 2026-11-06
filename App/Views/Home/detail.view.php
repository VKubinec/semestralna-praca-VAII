<?php
/** @var \App\Models\Vozidlo $vozidlo */
/** @var \Framework\Support\LinkGenerator $link */
// AI-assisted adaptation of the assignment-4 vehicle detail: ChatGPT, assignment 6.
$h = static fn (mixed $value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
$formatDate = static fn (?string $date): string => $date ? date('d. m. Y', strtotime($date)) : '-';
?>
<section class="detail-heading">
  <div>
    <p class="breadcrumb"><a href="<?= $link->url('vozidlo.index') ?>">Moje vozidl&aacute;</a> / <?= $h($vozidlo->znacka . ' ' . $vozidlo->model) ?></p>
    <h1><?= $h($vozidlo->znacka . ' ' . $vozidlo->model) ?></h1>
    <p class="meta"><?= $h($vozidlo->ecv) ?> &nbsp;&bull;&nbsp; <?= $vozidlo->rok_vyroby ?> &nbsp;&bull;&nbsp; <?= $h($vozidlo->palivo) ?></p>
  </div>
  <div class="btn-row">
    <a class="btn" href="<?= $link->url('vozidlo.edit', ['id' => $vozidlo->id]) ?>">Upravi&#357;</a>
    <form method="post" action="<?= $link->url('vozidlo.delete') ?>">
      <input type="hidden" name="id" value="<?= $vozidlo->id ?>">
      <button class="btn" type="submit">Odstr&aacute;ni&#357;</button>
    </form>
  </div>
</section>

<section class="panel vehicle-card" aria-label="Z&aacute;kladn&eacute; &uacute;daje vozidla">
  <div class="vehicle-image" aria-hidden="true">
    <svg class="car-icon" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
      <path d="M13 39h11l13-18h42l14 18h14" fill="none" stroke="currentColor" stroke-width="2"/>
      <path d="M24 39h69" fill="none" stroke="currentColor" stroke-width="2"/>
      <circle cx="34" cy="43" r="7" fill="white" stroke="currentColor" stroke-width="2"/>
      <circle cx="85" cy="43" r="7" fill="white" stroke="currentColor" stroke-width="2"/>
    </svg>
  </div>
  <div><span class="info-label">VIN</span><span class="info-value"><?= $h($vozidlo->vin ?: '-') ?></span></div>
  <div><span class="info-label">Stav km</span><span class="info-value"><?= number_format($vozidlo->stav_km, 0, ',', ' ') ?> km</span></div>
  <div><span class="info-label">STK do</span><span class="info-value"><?= $formatDate($vozidlo->stk_do) ?></span></div>
  <div><span class="info-label">EK do</span><span class="info-value"><?= $formatDate($vozidlo->ek_do) ?></span></div>
  <div><span class="info-label">Pl&aacute;novan&yacute; servis</span><span class="info-value"><?= $formatDate($vozidlo->servis_do) ?></span></div>
</section>

<section class="stat-grid" aria-label="S&uacute;hrn vozidla">
  <article class="panel stat-card"><span class="muted">Zna&#269;ka</span><strong><?= $h($vozidlo->znacka) ?></strong></article>
  <article class="panel stat-card"><span class="muted">Model</span><strong><?= $h($vozidlo->model) ?></strong></article>
  <article class="panel stat-card"><span class="muted">Rok v&yacute;roby</span><strong><?= $vozidlo->rok_vyroby ?></strong></article>
  <article class="panel stat-card"><span class="muted">Palivo</span><strong><?= $h($vozidlo->palivo) ?></strong></article>
</section>

<section class="detail-grid">
  <article class="panel history-panel">
    <h2 class="panel-title">Hist&oacute;ria vozidla</h2>
    <p class="demo-note">Uk&aacute;&#382;kov&eacute; servisn&eacute; z&aacute;znamy z predch&aacute;dzaj&uacute;cej &uacute;lohy. Zatia&#318; nie s&uacute; v datab&aacute;ze.</p>
    <div class="history-toolbar">
      <div class="tabs" aria-label="Typ hist&oacute;rie">
        <button class="btn tab active" type="button" disabled>Servis</button>
        <button class="btn tab" type="button" disabled>Tankovania</button>
        <button class="btn tab" type="button" disabled>Dokumenty</button>
      </div>
      <button class="btn btn-primary" type="button" disabled>+ Prida&#357; servis</button>
    </div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>&Uacute;kon</th><th>D&aacute;tum</th><th>Stav km</th><th>Cena</th></tr></thead>
        <tbody>
          <tr><td>Olej + filtre</td><td>15. 09. 2026</td><td>140 020</td><td>210 &euro;</td></tr>
          <tr><td>Brzdov&eacute; platni&#269;ky</td><td>10. 04. 2026</td><td>135 600</td><td>380 &euro;</td></tr>
          <tr><td>Klimatiz&aacute;cia</td><td>19. 06. 2025</td><td>123 450</td><td>95 &euro;</td></tr>
        </tbody>
      </table>
    </div>
  </article>

  <aside class="panel side-panel">
    <section class="side-section">
      <h2 class="panel-title">Nadch&aacute;dzaj&uacute;ce term&iacute;ny</h2>
      <div class="deadline-list">
        <div class="deadline-item"><strong>Pl&aacute;novan&yacute; servis</strong><span><?= $formatDate($vozidlo->servis_do) ?></span></div>
        <div class="deadline-item"><strong>STK</strong><span><?= $formatDate($vozidlo->stk_do) ?></span></div>
        <div class="deadline-item"><strong>EK</strong><span><?= $formatDate($vozidlo->ek_do) ?></span></div>
      </div>
    </section>
    <section class="side-section">
      <h3>Dokumenty</h3>
      <p class="demo-note">Evidencia dokumentov bude doplnen&aacute; v &#271;al&#353;ej f&aacute;ze.</p>
    </section>
  </aside>
</section>
