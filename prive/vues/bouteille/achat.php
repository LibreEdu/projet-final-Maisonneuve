<main class="mdl-layout__content">			
	<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="btnAjouterBouteille">
	  Ajouter une bouteille
	</button>
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">		
		<div class="mdl-card__title">	
			<h2 class="mdl-card__title-text">Mes listes d'achat</h2>		
		</div>
		<div class="mdl-card__supporting-text">
			<?php foreach ($donnees['noms'] as $nom_liste): ?>
			<h5 class="afficher_details"><?php echo $nom_liste->nom; ?></h5>
			<?php foreach ($donnees['listes'] as $liste) { 
				if($liste->id_liste_achat == $nom_liste->id_liste_achat) { ?>
			<div class="details">
				</strong> <?php echo $liste->nom; ?> <strong><?php echo $liste->prix; ?> $</strong>
			</div>
		<?php } } ?>
		<?php endforeach; ?>
		</div>
	</div>
</main>