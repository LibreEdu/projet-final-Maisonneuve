<div class='cellier'>
<?php
foreach ($donnees as $bouteille) {
 
	?>
	<div class='bouteille' data-quantite=''>
		<div class='img'>
			<img src='https://s7d9.scene7.com/is/image/SAQ/<?php echo $bouteille['code_SAQ']; ?>_is?$saq-rech-prod-list$'>
		</div>
		<div class='description'>
			<p class='nom'><?php echo $bouteille['nom']; ?> <?php echo $bouteille['millesime']; ?></p>
			<p class='type'><?php echo $bouteille['type']; ?></p>
			<p class='pays'><?php echo $bouteille['pays']; ?>, <?php echo $bouteille['format']; ?></p>
			<p class='boireAvant'>Boire avant : <?php echo $bouteille['date_buvable'] ?></p>
			<!-- <p class='quantite'>Quantité : <?php echo $bouteille['quantite'] ?></p> -->
			 <p class='quantite' id='<?php echo $bouteille['id_cellier_bouteille'] ?>'>Quantité : <?php echo $bouteille['quantite'] ?></p>
			<p class='dateAchat'>Date d’achat : <?php echo $bouteille['date_achat'] ?></p>
			<p class='prix'>Prix : <?php echo number_format($bouteille['prix'], 2, ',', ' ') ?> $</p>
			<p><a href='https://www.saq.com/page/fr/saqcom///<?php echo $bouteille['code_SAQ'] ?>'>Lien SAQ</a></p>
		</div>
		<div class='options' data-id='<?php echo $bouteille['id_cellier_bouteille'] ?>'>
			
			<button class='btnModifier'>Modifier</button>
			<button class='btnAjouter'>Ajouter</button>
			<button class='btnBoire'>Boire</button>
			
		</div>
	</div>
<?php
}
?>	
</div>
