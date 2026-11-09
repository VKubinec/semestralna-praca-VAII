<?php
/** @var \App\Models\Tankovanie[] $tankovania */
/** @var \App\Models\Vozidlo[] $vozidla */
/** @var int|null $vybraneVozidloId */
/** @var \Framework\Support\LinkGenerator $link */
$h = static fn (mixed $value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
$nazvyVozidiel = [];
foreach ($vozidla as $vozidlo) {
    $nazvyVozidiel[$vozidlo->id] = $vozidlo->znacka . ' ' . $vozidlo->model . ' (' . $vozidlo->ecv . ')';
}
$celkoveNaklady = array_reduce(
    $tankovania,
    static fn (float $sum, $item): float => $sum + (float) $item->mnozstvo_l * (float) $item->cena_za_liter,
    0.0
);
$celkoveLitre = array_reduce($tankovania, static fn (float $sum, $item): float => $sum + (float) $item->mnozstvo_l, 0.0);
?>
<section class="page-heading">
  <div>
    <h1>Tankovania</h1>
    <p class="subtitle">Evidencia paliva a nákladov pre jednotlivé vozidlá.</p>
  </div>
  <?php if ($vozidla): ?>
    <a class="btn btn-primary" href="<?= $link->url('tankovanie.create') ?>">+ Pridať tankovanie</a>
  <?php endif; ?>
</section>

<?php if (!$vozidla): ?>
  <section class="panel vehicle-list-panel">
    <p>Najprv je potrebné vytvoriť vozidlo.</p>
    <a class="btn" href="<?= $link->url('vozidlo.create') ?>">Pridať vozidlo</a>
  </section>
<?php else: ?>
  <section class="panel vehicle-list-panel" aria-label="Tankovania">
    <div class="summary-grid" style="margin-bottom:20px">
      <article class="placeholder-card"><span class="muted">Počet tankovaní</span><strong class="summary-number"><?= count($tankovania) ?></strong></article>
      <article class="placeholder-card"><span class="muted">Natankované litre</span><strong class="summary-number"><?= number_format($celkoveLitre, 2, ',', ' ') ?> l</strong></article>
      <article class="placeholder-card"><span class="muted">Náklady na palivo</span><strong class="summary-number"><?= number_format($celkoveNaklady, 2, ',', ' ') ?> €</strong></article>
    </div>
    <form method="get" class="form-grid" style="margin-bottom:20px">
      <input type="hidden" name="c" value="tankovanie">
      <div class="form-field">
        <label for="filter-vozidlo">Filtrovať podľa vozidla</label>
        <select id="filter-vozidlo" name="vozidlo_id">
          <option value="">Všetky vozidlá</option>
          <?php foreach ($vozidla as $vozidlo): ?>
            <option value="<?= $vozidlo->id ?>"<?= $vybraneVozidloId === $vozidlo->id ? ' selected' : '' ?>><?= $h($nazvyVozidiel[$vozidlo->id]) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-actions" style="margin:0;align-self:end;justify-content:flex-start">
        <button class="btn" type="submit">Filtrovať</button>
        <a class="btn" href="<?= $link->url('tankovanie.index') ?>">Všetky</a>
      </div>
    </form>

    <?php if (!$tankovania): ?>
      <p>Pre vybrané vozidlá zatiaľ nie sú evidované žiadne tankovania.</p>
    <?php else: ?>
      <div class="table-wrap">
        <table class="records-table">
          <thead>
            <tr><th>Dátum</th><th>Vozidlo</th><th>Litrov</th><th>Cena/l</th><th>Spolu</th><th>Stav km</th><th>Stanica</th><th>Akcie</th></tr>
          </thead>
          <tbody>
            <?php foreach ($tankovania as $tankovanie): ?>
              <tr>
                <td data-label="Dátum"><?= date('d. m. Y', strtotime($tankovanie->datum_tankovania)) ?></td>
                <td data-label="Vozidlo"><a href="<?= $link->url('home.detail', ['id' => $tankovanie->vozidlo_id]) ?>"><?= $h($nazvyVozidiel[$tankovanie->vozidlo_id] ?? 'Neznáme vozidlo') ?></a></td>
                <td data-label="Litrov"><?= number_format((float) $tankovanie->mnozstvo_l, 2, ',', ' ') ?> l</td>
                <td data-label="Cena/l"><?= number_format((float) $tankovanie->cena_za_liter, 3, ',', ' ') ?> €</td>
                <td data-label="Spolu"><?= number_format((float) $tankovanie->mnozstvo_l * (float) $tankovanie->cena_za_liter, 2, ',', ' ') ?> €</td>
                <td data-label="Stav km"><?= number_format($tankovanie->stav_km, 0, ',', ' ') ?> km</td>
                <td data-label="Stanica"><?= $h($tankovanie->cerpacia_stanica ?: '—') ?></td>
                <td data-label="Akcie">
                  <div class="row-actions">
                    <a class="btn btn-small" href="<?= $link->url('tankovanie.edit', ['id' => $tankovanie->id]) ?>">Upraviť</a>
                    <form method="post" action="<?= $link->url('tankovanie.delete') ?>">
                      <input type="hidden" name="id" value="<?= $tankovanie->id ?>">
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
