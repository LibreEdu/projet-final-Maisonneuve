	<main class="mdl-layout__content">
		<div class="mdl-layout__tab-panel is-active" id="overview">
			<?php foreach ($data['bouteilles'] as $bouteille): ?>
			<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
				<header class="section__play-btn mdl-cell mdl-cell--3-col-desktop mdl-cell--2-col-tablet mdl-cell--4-col-phone mdl-color--teal-100 mdl-color-text--white">
					<div class='bouteille' data-quantite=''>
						<div class='img'>
							<img src='https://s7d9.scene7.com/is/image/SAQ/<?php echo $bouteille->code_saq; ?>_is?$saq-rech-prod-gril$'>
						</div>
					</div>
				</header>
				<div class="mdl-card mdl-cell mdl-cell--9-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone">
					<div class="mdl-card__supporting-text">
						<h4 class='nom'><?php echo $bouteille->nom; ?> <?php echo $bouteille->millesime; ?></h4>
						<p class='type'><?php echo $bouteille->id_type; ?></p>
						<p class='pays'><?php echo $bouteille->pays; ?>, <?php echo $bouteille->format; ?></p>
						<p class='boireAvant'>Boire avant : <?php echo $bouteille->boire_avant ?></p>
						<p class='quantite' id='<?php echo $bouteille->id_bouteille; ?>'>Quantité : <?php echo $bouteille->quantite ?></p>
						<p class='dateAchat'>Date d’achat : <?php echo $bouteille->date_achat ?></p>
						<p class='prix'>Prix : <?php echo number_format($bouteille->prix, 2, ',', ' ') ?> $</p>
					</div>
					<div class="mdl-card__actions">
						<p><a href='https://www.saq.com/page/fr/saqcom///<?php echo $bouteille->code_saq ?>'target="_blank">Lien SAQ</a></p>
						<p>
						<div class='options' data-id='<?php echo $bouteille->id_bouteille ?>'>
							<button class="mdl-button mdl-js-button mdl-button--raised btnModifier" >Modifier</button>
							<button class='btnAjouter mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>Ajouter</button>
							<button class='btnBoire mdl-button mdl-js-button mdl-button--raised mdl-button--accent'>Boire</button>
						</div>
						</p>
					</div>
				</div>
				<ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right" for="btn1">
				<li class="mdl-menu__item">Lorem</li>
				<li class="mdl-menu__item" disabled>Ipsum</li>
				<li class="mdl-menu__item">Dolor</li>
				</ul>
			</section>
			<?php endforeach; ?>
		</div>

