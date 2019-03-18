      <main class="mdl-layout__content">
        <div class="mdl-layout__tab-panel is-active" id="overview">
          <!-- Récupérer les données  -->
          <?php
            foreach ($data as $bouteille) {
          ?>
            <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
              <div class="mdl-card mdl-cell mdl-cell--12-col">
                <div class="mdl-card__supporting-text mdl-grid mdl-grid--no-spacing">
                  <h4 class="mdl-cell mdl-cell--12-col"><?php echo $bouteille['nom']. " ".$bouteille['millesime']; ?></h4>
                  <div class="section__circle-container mdl-cell mdl-cell--2-col mdl-cell--1-col-phone">
                    <div class="section__circle-container__circle mdl-color--primary"></div>
                  </div>
                  <div class="section__text mdl-cell mdl-cell--10-col-desktop mdl-cell--6-col-tablet mdl-cell--3-col-phone">
                    <h5><?php echo $bouteille['code_saq']; ?></h5>
                    <h5><?php echo $bouteille['type']; ?></h5>
                    <h5><?php echo $bouteille['pays']; ?></h5>
                    <h5><?php echo $bouteille['format']; ?></h5>
                    <h5><?php echo number_format($bouteille['prix'], 2, ',', ' ')." $"; ?></h5>
                  </div>
                </div>
                <div class="mdl-card__actions">
                  <a href="#" class="mdl-button">Read our features</a>
                </div>
              </div>
              <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btn2">
                <i class="material-icons">more_vert</i>
              </button>
              <ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right" for="btn2">
                <li class="mdl-menu__item">Lorem</li>
                <li class="mdl-menu__item" disabled>Ipsum</li>
                <li class="mdl-menu__item">Dolor</li>
              </ul>
            </section>
          <?php
            }
          ?>