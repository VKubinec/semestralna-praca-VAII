<?php
/** @var array $formValues */
/** @var \App\Models\Vozidlo[] $vozidla */
/** @var bool $editing */
/** @var string|null $error */
/** @var \Framework\Support\LinkGenerator $link */
$h = static fn (mixed $value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
?>
<section class="page-heading">
  <div>
    <h1><?= $editing ? 'Upraviť tankovanie' : 'Pridať tankovanie' ?></h1>
    <p class="subtitle">Zaznamenaj dátum, množstvo paliva a cenu za liter.</p>
  </div>
</section>

<?php if (!$vozidla): ?>
  <section class="panel form-panel">
    <p>Na vytvorenie tankovania musí byť evidované aspoň jedno vozidlo.</p>
    <a class="btn" href="<?= $link->url('vozidlo.create') ?>">Pridať vozidlo</a>
  </section>
<?php else: ?>
  <form class="panel form-panel" action="<?= $link->url('tankovanie.save') ?>" method="post">
    <input type="hidden" name="id" value="<?= $h($formValues['id']) ?>">
    <?php if ($error): ?>
      <p class="form-error" role="alert"><?= $h($error) ?></p>
    <?php endif; ?>
    <div class="form-grid">
      <div class="form-field">
        <label for="vozidlo_id">Vozidlo</label>
        <select id="vozidlo_id" name="vozidlo_id" required>
          <?php foreach ($vozidla as $vozidlo): ?>
            <option value="<?= $vozidlo->id ?>"<?= (string) $formValues['vozidlo_id'] === (string) $vozidlo->id ? ' selected' : '' ?>>
              <?= $h($vozidlo->znacka . ' ' . $vozidlo->model . ' (' . $vozidlo->ecv . ')') ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-field">
        <label for="datum_tankovania">Dátum tankovania</label>
        <input id="datum_tankovania" name="datum_tankovania" type="date" required value="<?= $h($formValues['datum_tankovania']) ?>">
      </div>
      <div class="form-field">
        <label for="mnozstvo_l">Množstvo paliva (l)</label>
        <input id="mnozstvo_l" name="mnozstvo_l" type="number" min="0.01" max="9999.99" step="0.01" required value="<?= $h($formValues['mnozstvo_l']) ?>">
      </div>
      <div class="form-field">
        <label for="cena_za_liter">Cena za liter (€)</label>
        <input id="cena_za_liter" name="cena_za_liter" type="number" min="0.001" max="99.999" step="0.001" required value="<?= $h($formValues['cena_za_liter']) ?>">
      </div>
      <div class="form-field">
        <label for="stav_km">Stav kilometrov</label>
        <input id="stav_km" name="stav_km" type="number" min="0" max="9999999" required value="<?= $h($formValues['stav_km']) ?>">
      </div>
      <div class="form-field">
        <label for="cerpacia_stanica">Čerpacia stanica (nepovinné)</label>
        <input id="cerpacia_stanica" name="cerpacia_stanica" type="text" maxlength="120" value="<?= $h($formValues['cerpacia_stanica']) ?>" placeholder="Napr. Slovnaft">
      </div>
    </div>
    <div class="form-actions">
      <a class="btn" href="<?= $link->url('tankovanie.index') ?>">Zrušiť</a>
      <button class="btn btn-primary" type="submit">Uložiť tankovanie</button>
    </div>
  </form>
<?php endif; ?>
