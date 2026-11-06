<?php
/** @var array $formValues */
/** @var bool $editing */
/** @var string|null $error */
/** @var \Framework\Support\LinkGenerator $link */
// AI-assisted CRUD form view: ChatGPT, VAII assignment 6.
$h = static fn (mixed $value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
?>
<section class="page-heading">
  <div>
    <h1><?= $editing ? 'Upravi&#357; vozidlo' : 'Prida&#357; vozidlo' ?></h1>
    <p class="subtitle">Vypl&#328; z&aacute;kladn&eacute; &uacute;daje vozidla.</p>
  </div>
</section>

<form class="panel form-panel" action="<?= $link->url('vozidlo.save') ?>" method="post">
  <input type="hidden" name="id" value="<?= $h($formValues['id']) ?>">
  <?php if ($error): ?>
    <p class="form-error" role="alert"><?= $h($error) ?></p>
  <?php endif; ?>

  <div class="form-grid">
    <div class="form-field">
      <label for="znacka">Zna&#269;ka</label>
      <input id="znacka" name="znacka" type="text" value="<?= $h($formValues['znacka']) ?>" maxlength="80" required>
    </div>
    <div class="form-field">
      <label for="model">Model</label>
      <input id="model" name="model" type="text" value="<?= $h($formValues['model']) ?>" maxlength="80" required>
    </div>
    <div class="form-field">
      <label for="rok_vyroby">Rok v&yacute;roby</label>
      <input id="rok_vyroby" name="rok_vyroby" type="number" value="<?= $h($formValues['rok_vyroby']) ?>" min="1900" max="<?= date('Y') + 1 ?>" required>
    </div>
    <div class="form-field">
      <label for="ecv">Eviden&#269;n&eacute; &#269;&iacute;slo</label>
      <input id="ecv" name="ecv" type="text" value="<?= $h($formValues['ecv']) ?>" maxlength="16" required>
    </div>
    <div class="form-field">
      <label for="vin">VIN (nepovinn&eacute;)</label>
      <input id="vin" name="vin" type="text" value="<?= $h($formValues['vin']) ?>" maxlength="17">
    </div>
    <div class="form-field">
      <label for="palivo">Druh paliva</label>
      <select id="palivo" name="palivo" required>
        <?php foreach (['Benzin' => 'Benz&iacute;n', 'Diesel' => 'Diesel', 'Hybrid' => 'Hybrid', 'Elektrina' => 'Elektrina', 'LPG' => 'LPG'] as $value => $caption): ?>
          <option value="<?= $value ?>"<?= $formValues['palivo'] === $value ? ' selected' : '' ?>><?= $caption ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-field">
      <label for="stav_km">Stav kilometrov</label>
      <input id="stav_km" name="stav_km" type="number" value="<?= $h($formValues['stav_km']) ?>" min="0" max="9999999" required>
    </div>
    <div class="form-field">
      <label for="stk_do">STK platn&aacute; do</label>
      <input id="stk_do" name="stk_do" type="date" value="<?= $h($formValues['stk_do']) ?>">
    </div>
    <div class="form-field">
      <label for="ek_do">EK platn&aacute; do</label>
      <input id="ek_do" name="ek_do" type="date" value="<?= $h($formValues['ek_do']) ?>">
    </div>
    <div class="form-field">
      <label for="servis_do">Pl&aacute;novan&yacute; servis</label>
      <input id="servis_do" name="servis_do" type="date" value="<?= $h($formValues['servis_do']) ?>">
    </div>
  </div>

  <div class="form-actions">
    <a class="btn" href="<?= $link->url('vozidlo.index') ?>">Zru&#353;i&#357;</a>
    <button type="submit" class="btn btn-primary">Ulo&#382;i&#357; vozidlo</button>
  </div>
</form>
