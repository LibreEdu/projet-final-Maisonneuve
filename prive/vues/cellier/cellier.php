	<main class="mdl-layout__content">
		<div class="mdl-layout__tab-panel is-active" id="overview">
			<section class="section--center mdl-grid mdl-grid--no-spacing">				
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
					<div class="mdl-textfield mdl-js-textfield">
						<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="pageRecherche">
						  Recherche
						</button>
						Recherche par  
						<!--<select id="recherchePar">
							<option value='' disabled selected style='display:none;'>-- selectionner --</option>
							<option value='millesime'>millesime</option>
							<option value='nom'>nom</option>
							<option value='pays'>pays</option>
							<option value='prix'>prix</option>	
							<option value='quantite'>quantite</option>							
							<option value='type'>type</option>
						</select>
						<select id="rechercheSpecifique" style='visibility: hidden;'>
							<option value='' disabled selected style='display:none;'>-- selectionner --</option>
							<option value=">=">plus grand ou égale</option>
							<option value="<=">plus petit ou égale</option>
						</select>-->
					</div>										
					<input class="mdl-textfield__input" type="search" id="btnRecherche" name="valeurRechercher" style="visibility: hidden;"/>					
					<ul class="rechercheParr"></ul>
					<ul class="autoComplete"></ul>
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
						if(isset($bouteille->code_saq)) {
					?>
						<img src='https://s7d9.scene7.com/is/image/SAQ/<?php echo $bouteille->code_saq; ?>_is?$saq-rech-prod-gril$'>
					<?php
						}
						else {
					?>
						<img src='../divers/images/bouteille.jpg'>
					<?php
						}
					?>
					</div>
				</header>
				<div class="mdl-card mdl-cell mdl-cell--9-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone">
					<div class="mdl-card__supporting-text">
						<h4 class='nom'><?php echo $bouteille->nom; ?> <?php echo $bouteille->millesime; ?></h4>
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
						<?php
							}
						?>
						<div class='options' data-id='<?php echo $bouteille->id_bouteille ?>'>
							<button class="mdl-button mdl-js-button mdl-button--raised btnModifier" >Modifier</button>
							<button class='btnAjouter mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>+ 1</button>
							<button class='btnBoire mdl-button mdl-js-button mdl-button--raised mdl-button--accent'>- 1</button>
						</div>
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
	</main>

