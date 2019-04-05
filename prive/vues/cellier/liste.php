	<main class="mdl-layout__content general">
		<div class="mdl-layout__tab-panel is-active general" id="overview">			
			<h3>Bienvenue <?php echo $_SESSION['prenom'] ?></h3>
			<!-- Bouton ajouter un cellier -->
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored" id="btnAjouterCellier" title="Ajouter un cellier">
			  <i class="material-icons">add</i>
			</button>
			<!-- Récupérer les données -->
			<?php
				foreach ($donnees["celliers"] as $cellier) {
			?>		
			<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp aaa">
				<header class="cellier_header section__play-btn mdl-cell mdl-cell--3-col-desktop mdl-cell--2-col-tablet mdl-cell--4-col-phone mdl-color--teal-100 mdl-color-text--white ccc">
					<img src="images/cellier-vin.jpg" alt="" />
				</header>			
				<div class="mdl-card mdl-cell mdl-cell--9-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone bbb">
					<div class="mdl-card__supporting-text">
						<h4 class="libelle">Cellier <?php echo $cellier->nom; ?></h4>
					</div>
					<div class="mdl-card__actions">
						<p>
							<div class="options" data-id_cellier="<?php echo $cellier->id_cellier ?>">
								<button class="btnVisiterCellier mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Voir</button>
								<button class="btnSupprimerCellier mdl-button mdl-js-button mdl-button--raised mdl-button--accent">Supprimer</button>
							</div>
						</p>
					</div>
				</div>
			</section>
			<?php
				}
			?>
		</div>
</main>

