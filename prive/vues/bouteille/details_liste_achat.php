<main class="mdl-layout__content">
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">
		<div class="mdl-card__title">
			<h3 class="mdl-card__title-text"><?php echo $_GET['nom']; ?></h3>	
		</div>
		<div class="mdl-card__supporting-text">
		<?php foreach ($donnees['listes'] as $bouteille): ?>
			<table class="liste_achat">
				<tr>
					<td><?php echo $bouteille->nom; ?></td>
					<td class="prix"><?php echo number_format($bouteille->prix, 2, ',', ' ') ?>&nbsp;$</td>
				</tr>											
			</table>		
		<?php endforeach; ?>
			<table class="total">
				<tr>
					<td><h6>TOTAL :</h6></td>
					<td class="prix">
					<?php 
						$prix = Array();
						foreach ($donnees['listes'] as $un_prix):
							array_push($prix, $un_prix->prix);
						endforeach;
							$total = array_sum($prix);
							echo number_format($total, 2, ',', ' '); 
					?>&nbsp;$
					</td>
				</tr>						
			</table>
			<p><a class="lien" href="index.php?liste_achat&action=listes_achat">Retourner à la liste d'achats</a>		
		</div>
	</div>
</main>

