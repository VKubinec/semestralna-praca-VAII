<?php
/** @var \App\Models\Vozidlo[] $vozidla */
/** @var \Framework\Support\LinkGenerator $link */
// AI-assisted CRUD list view: ChatGPT, VAII assignment 6.
?>
<section class="page-heading">
  <div>
    <h1>Moje vozidl&aacute;</h1>
    <p class="subtitle">Vozidl&aacute; na&#269;&iacute;tan&eacute; z datab&aacute;zy Va&iacute;&iacute;&#269;ka.</p>
  </div>
  <a class="btn btn-primary" href="<?= $link->url('vozidlo.create') ?>">+ Prida&#357; vozidlo</a>
</section>

<section class="panel vehicle-list-panel" aria-label="Zoznam vozidiel">
  <?php if (!$vozidla): ?>
    <p>Zatia&#318; nie s&uacute; ulo&#382;en&eacute; &#382;iadne vozidl&aacute;.</p>
  <?php else: ?>
    <div class="table-wrap">
      <table class="records-table">
        <thead>
          <tr>
            <th>Vozidlo</th>
            <th>E&#268;V</th>
            <th>Rok</th>
            <th>Stav km</th>
            <th>Palivo</th>
            <th>Akcie</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($vozidla as $vozidlo): ?>
            <tr>
              <td data-label="Vozidlo"><strong><?= htmlspecialchars($vozidlo->znacka . ' ' . $vozidlo->model, ENT_QUOTES, 'UTF-8') ?></strong></td>
              <td data-label="E&#268;V"><?= htmlspecialchars($vozidlo->ecv, ENT_QUOTES, 'UTF-8') ?></td>
              <td data-label="Rok"><?= $vozidlo->rok_vyroby ?></td>
              <td data-label="Stav km"><?= number_format($vozidlo->stav_km, 0, ',', ' ') ?> km</td>
              <td data-label="Palivo"><?= htmlspecialchars($vozidlo->palivo, ENT_QUOTES, 'UTF-8') ?></td>
              <td data-label="Akcie">
                <div class="row-actions">
                  <a class="btn btn-small" href="<?= $link->url('home.detail', ['id' => $vozidlo->id]) ?>">Detail</a>
                  <a class="btn btn-small" href="<?= $link->url('vozidlo.edit', ['id' => $vozidlo->id]) ?>">Upravi&#357;</a>
                  <form method="post" action="<?= $link->url('vozidlo.delete') ?>">
                    <input type="hidden" name="id" value="<?= $vozidlo->id ?>">
                    <button class="btn btn-small" type="submit">Odstr&aacute;ni&#357;</button>
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
