<?php
/** @var \App\Models\ServisnyZaznam[] $zaznamy */
/** @var \App\Models\Vozidlo[] $vozidla */
/** @var int|null $vybraneVozidloId */
/** @var \Framework\Support\LinkGenerator $link */
// AI-assisted implementation: ChatGPT, VAII assignment 7.
$h = static fn (mixed $value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
$nazvyVozidiel = [];
foreach ($vozidla as $vozidlo) {
    $nazvyVozidiel[$vozidlo->id] = $vozidlo->znacka . ' ' . $vozidlo->model . ' (' . $vozidlo->ecv . ')';
}
?>
<section class="page-heading">
  <div>
    <h1>Servisná história</h1>
    <p class="subtitle">Servisné úkony priradené k evidovaným vozidlám.</p>
  </div>
  <?php if ($vozidla): ?>
    <a class="btn btn-primary" href="<?= $link->url('servis.create') ?>">+ Pridať servis</a>
  <?php endif; ?>
</section>

<?php if (!$vozidla): ?>
  <section class="panel vehicle-list-panel">
    <p>Najprv je potrebné vytvoriť vozidlo.</p>
    <a class="btn" href="<?= $link->url('vozidlo.create') ?>">Pridať vozidlo</a>
  </section>
<?php else: ?>
  <section class="panel vehicle-list-panel" aria-label="Zoznam servisných záznamov">
    <form method="get" class="form-grid" style="margin-bottom:20px">
      <input type="hidden" name="c" value="servis">
      <div class="form-field">
        <label for="filter-vozidlo">Filtrovať podľa vozidla</label>
        <select id="filter-vozidlo" name="vozidlo_id">
          <option value="">Všetky vozidlá</option>
          <?php foreach ($vozidla as $vozidlo): ?>
            <option value="<?= $vozidlo->id ?>"<?= $vybraneVozidloId === $vozidlo->id ? ' selected' : '' ?>>
              <?= $h($nazvyVozidiel[$vozidlo->id]) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-actions" style="margin:0;align-self:end;justify-content:flex-start">
        <button class="btn" type="submit">Filtrovať</button>
        <a class="btn" href="<?= $link->url('servis.index') ?>">Všetky</a>
      </div>
    </form>

    <?php if (!$zaznamy): ?>
      <p>Zatiaľ nie sú evidované žiadne servisné záznamy.</p>
    <?php else: ?>
      <div class="table-wrap">
        <table class="records-table">
          <thead>
            <tr><th>Úkon</th><th>Vozidlo</th><th>Dátum</th><th>Stav km</th><th>Cena</th><th>Akcie</th></tr>
          </thead>
          <tbody>
          <?php foreach ($zaznamy as $zaznam): ?>
            <tr>
              <td data-label="Úkon"><strong><?= $h($zaznam->nazov_ukonu) ?></strong></td>
              <td data-label="Vozidlo">
                <a href="<?= $link->url('home.detail', ['id' => $zaznam->vozidlo_id]) ?>">
                  <?= $h($nazvyVozidiel[$zaznam->vozidlo_id] ?? 'Neznáme vozidlo') ?>
                </a>
              </td>
              <td data-label="Dátum"><?= date('d. m. Y', strtotime($zaznam->datum_servisu)) ?></td>
              <td data-label="Stav km"><?= number_format($zaznam->stav_km, 0, ',', ' ') ?> km</td>
              <td data-label="Cena"><?= number_format((float) $zaznam->cena, 2, ',', ' ') ?> €</td>
              <td data-label="Akcie">
                <div class="row-actions">
                  <a class="btn btn-small" href="<?= $link->url('servis.edit', ['id' => $zaznam->id]) ?>">Upraviť</a>
                  <form action="<?= $link->url('servis.delete') ?>" method="post">
                    <input type="hidden" name="id" value="<?= $zaznam->id ?>">
                    <button class="btn btn-small" type="submit">Odstrániť</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>
<?php endif; ?>
