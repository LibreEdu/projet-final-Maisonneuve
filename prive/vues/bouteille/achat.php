<main class="mdl-layout__content">
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">		
		<div class="mdl-card__title">	
			<h2 class="mdl-card__title-text">Mes listes d'achat</h2>		
		</div>
		<div name="achats" class="mdl-card__supporting-text">
			<?php foreach ($donnees['noms'] as $nom_liste): ?>
			<div>
				<h5><?php echo $nom_liste->nom; ?></h5> <a class="lien" href="index.php?liste_achat&action=details_liste_achat&nom=<?php echo $nom_liste->nom; ?>">Afficher les détails</a>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</main>