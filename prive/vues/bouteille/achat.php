<main class="mdl-layout__content">
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">		
		<div class="mdl-card__title">	
			<h2 class="mdl-card__title-text">Mes listes d'achat</h2>		
		</div>
		<div name="achats" class="mdl-card__supporting-text">
			<?php 
				if(isset($donnees['noms'])) {
					foreach ($donnees['noms'] as $nom_liste): ?>
			<div class="nom_liste">
				<h5><a class="lien" href="index.php?liste_achat&action=details_liste_achat&nom=<?php echo $nom_liste->nom; ?>"><?php echo $nom_liste->nom; ?></a></h5>
			</div>
		<?php endforeach; }
			else { ?>
			<div>
				<p>Aucune liste à afficher</p>
			</div>
			<?php } ?>	
			<div class="bouton">
				<p><a class="lien" href="index.php?liste_achat&action=liste_form">Créer une liste d'achat</a></p>
			</div>
		</div>
	</div>
</main>