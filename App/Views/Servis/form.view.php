<?php
/** @var array $formValues */
/** @var \App\Models\Vozidlo[] $vozidla */
/** @var bool $editing */
/** @var string|null $error */
/** @var \Framework\Support\LinkGenerator $link */
// AI-assisted implementation: ChatGPT, VAII assignment 7.
$h = static fn (mixed $value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
?>
<section class="page-heading">
  <div>
    <h1><?= $editing ? 'Upraviť servisný záznam' : 'Pridať servisný záznam' ?></h1>
    <p class="subtitle">Vyber vozidlo a vyplň údaje o servisnom úkone.</p>
  </div>
</section>

<?php if (!$vozidla): ?>
  <section class="panel form-panel">
    <p>Na vytvorenie servisného záznamu je potrebné najprv pridať vozidlo.</p>
    <a class="btn" href="<?= $link->url('vozidlo.create') ?>">Pridať vozidlo</a>
  </section>
<?php else: ?>
  <form class="panel form-panel" action="<?= $link->url('servis.save') ?>" method="post">
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
        <label for="nazov_ukonu">Servisný úkon</label>
        <input id="nazov_ukonu" name="nazov_ukonu" type="text" maxlength="120" required value="<?= $h($formValues['nazov_ukonu']) ?>" placeholder="Napr. Výmena oleja">
      </div>
      <div class="form-field">
        <label for="datum_servisu">Dátum servisu</label>
        <input id="datum_servisu" name="datum_servisu" type="date" required value="<?= $h($formValues['datum_servisu']) ?>">
      </div>
      <div class="form-field">
        <label for="stav_km">Stav kilometrov pri servise</label>
        <input id="stav_km" name="stav_km" type="number" min="0" max="9999999" required value="<?= $h($formValues['stav_km']) ?>">
      </div>
      <div class="form-field">
        <label for="cena">Celková cena (€)</label>
        <input id="cena" name="cena" type="number" min="0" max="99999999.99" step="0.01" required value="<?= $h($formValues['cena']) ?>">
      </div>
      <div class="form-field">
        <label for="nazov_servisu">Názov servisu (nepovinné)</label>
        <input id="nazov_servisu" name="nazov_servisu" type="text" maxlength="150" value="<?= $h($formValues['nazov_servisu']) ?>">
      </div>
      <div class="form-field" style="grid-column:1/-1">
        <label for="popis">Opis prác (nepovinné)</label>
        <input id="popis" name="popis" type="text" maxlength="500" value="<?= $h($formValues['popis']) ?>">
      </div>
    </div>
    <div class="form-actions">
      <a class="btn" href="<?= $link->url('servis.index') ?>">Zrušiť</a>
      <button class="btn btn-primary" type="submit">Uložiť servis</button>
    </div>
  </form>
<?php endif; ?>
