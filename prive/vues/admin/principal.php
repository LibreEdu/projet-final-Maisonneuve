		<main class="mdl-layout__content">
		<div class="mdl-layout__tab-panel is-active" id="overview">
			<h3>Bonjour <?php echo $donnees['prenom'] ?></h3>
			<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
				<header class="section__play-btn mdl-cell mdl-cell--3-col-desktop mdl-cell--2-col-tablet mdl-cell--4-col-phone mdl-color--teal-100 mdl-color-text--white">					
				</header>
			
				<div class="mdl-card mdl-cell mdl-cell--9-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone">
					<div class="mdl-card__supporting-text">
						<h4 class="libelle">Importer les bouteilles de la SAQ</h4>
					</div>
					<div class="mdl-card__actions">
						<p>
						<form method="POST" action='index.php?admin&action=importer'>
							<div class="mdl-textfield mdl-js-textfield">
								Nombre de bouteilles à importer : <input class="mdl-textfield__input" type="number" min="1" name="nbBouteilles" required="required">
							</div>
							<div>
								<input type="submit" value="Importer" class="mdl-button mdl-js-button mdl-button--raised">
							</div>
						</form>
						</p>
					</div>
				</div>
			</section>
		</div>
		</main>

