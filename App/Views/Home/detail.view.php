<?php // AI-assisted extraction of main content from html/detail.html (assignment 4). ?>
<section class="detail-heading">
  <div>
    <p class="breadcrumb">Moje vozidl&aacute; / &Scaron;koda Octavia III</p>
    <h1>&Scaron;koda Octavia III</h1>
    <p class="meta">ZA-123AB &nbsp;&bull;&nbsp; 2018 &nbsp;&bull;&nbsp; Diesel</p>
  </div>
  <div class="btn-row">
    <button class="btn" type="button">Upravi&#357;</button>
    <button class="btn" type="button">Odstr&aacute;ni&#357;</button>
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

  <div>
    <span class="info-label">VIN</span>
    <span class="info-value">TMBJG7NE8J0123456</span>
  </div>
  <div>
    <span class="info-label">Stav km</span>
    <span class="info-value">142 350 km</span>
  </div>
  <div>
    <span class="info-label">STK do</span>
    <span class="info-value">14. 05. 2027</span>
  </div>
  <div>
    <span class="info-label">EK do</span>
    <span class="info-value">14. 05. 2027</span>
  </div>
  <div>
    <span class="info-label">Pl&aacute;novan&yacute; servis</span>
    <span class="info-value">01. 11. 2026</span>
  </div>
</section>

<section class="stat-grid" aria-label="S&uacute;hrn vozidla">
  <article class="panel stat-card">
    <span class="muted">Servisn&eacute; n&aacute;klady</span>
    <strong>1 420 &euro;</strong>
  </article>
  <article class="panel stat-card">
    <span class="muted">Palivo</span>
    <strong>2 185 &euro;</strong>
  </article>
  <article class="panel stat-card">
    <span class="muted">Spolu</span>
    <strong>3 605 &euro;</strong>
  </article>
  <article class="panel stat-card">
    <span class="muted">Dokumenty</span>
    <strong>6 s&uacute;borov</strong>
  </article>
</section>

<section class="detail-grid">
  <article class="panel history-panel">
    <h2 class="panel-title">Hist&oacute;ria vozidla</h2>

    <div class="history-toolbar">
      <div class="tabs" aria-label="Typ hist&oacute;rie">
        <button class="btn tab active" type="button">Servis</button>
        <button class="btn tab" type="button">Tankovania</button>
        <button class="btn tab" type="button">Dokumenty</button>
      </div>
      <button class="btn btn-primary" type="button">+ Prida&#357; servis</button>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>&Uacute;kon</th>
            <th>D&aacute;tum</th>
            <th>Stav km</th>
            <th>Cena</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Olej + filtre</td>
            <td>15. 09. 2026</td>
            <td>140 020</td>
            <td>210 &euro;</td>
          </tr>
          <tr>
            <td>Brzdov&eacute; platni&#269;ky</td>
            <td>10. 04. 2026</td>
            <td>135 600</td>
            <td>380 &euro;</td>
          </tr>
          <tr>
            <td>Klimatiz&aacute;cia</td>
            <td>19. 06. 2025</td>
            <td>123 450</td>
            <td>95 &euro;</td>
          </tr>
        </tbody>
      </table>
    </div>
  </article>

  <aside class="panel side-panel">
    <section class="side-section">
      <h2 class="panel-title">Nadch&aacute;dzaj&uacute;ce term&iacute;ny</h2>
      <div class="deadline-list">
        <div class="deadline-item"><strong>Pl&aacute;novan&yacute; servis</strong><span>01. 11. 2026</span></div>
        <div class="deadline-item"><strong>STK</strong><span>14. 05. 2027</span></div>
        <div class="deadline-item"><strong>EK</strong><span>14. 05. 2027</span></div>
      </div>
      <p class="service-name">AutoServis &#381;ilina</p>
    </section>

    <section class="side-section">
      <h3>Dokumenty</h3>
      <div class="document-list">
        <div class="document-item"><span>Technick&yacute; preukaz.pdf</span><button class="download-btn" type="button">Stiahnu&#357;</button></div>
        <div class="document-item"><span>Poistka_2026.pdf</span><button class="download-btn" type="button">Stiahnu&#357;</button></div>
      </div>
    </section>
  </aside>
</section>
