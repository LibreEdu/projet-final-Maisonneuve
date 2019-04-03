
	<main class="mdl-layout__content">
		<div class="mdl-layout__tab-panel is-active" id="overview">
			<section class="section--center mdl-grid mdl-grid--no-spacing">				
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
					<div class="mdl-textfield mdl-js-textfield">
						<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="pageRecherche">
						  Recherche
						</button>
					</div>
					<input class="mdl-textfield__input" type="search" id="btnRecherche" name="valeurRechercher" style="visibility: hidden;"/>
				</div>
			</section>
		  	<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="btnAjouterBouteille">
			  Ajouter une bouteille
			</button>
			<?php foreach ($donnees['bouteilles'] as $bouteille): ?>
			<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
				<header class="section__play-btn mdl-cell mdl-cell--3-col-desktop mdl-cell--2-col-tablet mdl-cell--4-col-phone mdl-color--teal-100 mdl-color-text--white">
					<div class='img'>
					<?php
						if(isset($bouteille->code_saq) && $bouteille->code_saq != null) {
					?>
						<img src='https://s7d9.scene7.com/is/image/SAQ/<?php echo $bouteille->code_saq; ?>_is?$saq-rech-prod-gril$'>
					<?php
						}
						else {
							if($bouteille->type == 'Vin blanc') {
					?>
						<img src='<?php echo base_url(); ?>images/vin_blanc.jpg'>
					<?php
							}
							if($bouteille->type == 'Vin rouge') {
					?>
						<img src='<?php echo base_url(); ?>images/vin_rouge.jpg'>
					<?php
							}
							if($bouteille->type == 'Vin rosé') {
					?>
						<img src='<?php echo base_url(); ?>images/vin_rose.jpg'>
					<?php
							}
						}
					?>
					</div>
				</header>
				<div class="mdl-card mdl-cell mdl-cell--9-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone">
					<div class="mdl-card__supporting-text">
						<h5 class='nom'><?php echo $bouteille->nom; ?> <?php echo $bouteille->millesime; ?></h5>
						<p class='type'><?php echo $bouteille->type; ?></p>
						<p class='pays'><?php echo $bouteille->pays; ?>, <?php echo $bouteille->format; ?></p>
						<p class='boireAvant'>Boire avant : <?php echo $bouteille->boire_avant ?></p>
						<p class='quantite' id='<?php echo $bouteille->id_bouteille; ?>'>Quantité : <?php echo $bouteille->quantite ?></p>
						<p class='dateAchat'>Date d’achat : <?php echo $bouteille->date_achat ?></p>
						<p class='prix'><?php echo number_format($bouteille->prix, 2, ',', ' ') ?> $</p>
					</div>
					<div class="mdl-card__actions">
						<?php
							if($bouteille->code_saq != null)
							{
						?>
						<p><a href='https://www.saq.com/page/fr/saqcom///<?php echo $bouteille->code_saq ?>'target="_blank">Lien SAQ</a></p>
						<!-- Division pour les liens de partage -->
						<div class="mdl-card__menu">
							
							<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
							<i class="material-icons">share</i>
							</button>
							
							<div class="partage">
									<!-- Facebook -->
								<div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-size="small">
									<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://www.saq.com/page/fr/saqcom///<?php echo $bouteille->code_saq ?>" class="fb-xfbml-parse-ignore">Partager</a>
								</div><br>

								<!-- Twitter -->
								<div>
									<a href="https://twitter.com/share?url=https://www.saq.com/page/fr/saqcom///<?php echo $bouteille->code_saq ?>" class="twitter-share-button" data-show-count="false">Tweet</a>
									<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
								</div>

								<!-- LinkedIn -->
								<div>
									<script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: fr_FR</script>
									<script type="IN/Share" data-url="https://www.saq.com/page/fr/saqcom///<?php echo $bouteille->code_saq ?>"></script>
								</div>
							</div>
						</div>				
						<?php
							}
						?>
						<p>
							<div class='options' data-id='<?php echo $bouteille->id_bouteille ?>'>
								<button class="mdl-button mdl-js-button mdl-button--raised btnModifier" >Modifier</button>
								<button class='btnAjouter mdl-button mdl-js-button mdl-button--raised mdl-button--colored' title="Ajouter">+ 1</button>
								<button class='btnBoire mdl-button mdl-js-button mdl-button--raised mdl-button--accent' title="Boire">- 1</button>
								<button class="mdl-button mdl-js-button mdl-button--raised supprimerBouteille" title="Supprimer" data-id_bouteiile_supprimer="<?php echo $bouteille->id_bouteille?>"><i class="far fa-trash-alt"></i></button>
							</div>
						</p>
					</div>
				</div>
			</section>
			<?php endforeach; ?>
		</div>
	</main>
	<script type="text/javascript">
		window.addEventListener("load", function(){
			document.getElementById("cellier").classList.add("active");
			document.getElementById("listes_achat").classList.remove("active");
			document.getElementById("moncompte").classList.remove("active");
	},  false)
	</script>

