<div class='modifier'>
 <div class='bouteille'>
			<form method='POST'>
				<p>Nom : <input name='nom' value='<?php echo $data['nom'] ?>'></p>
				<p>Millesime : <input name='millesime' value='<?php echo $data['millesime'] ?>'></p>
				<p>Quantite : <input name='quantite' value='<?php echo $data['quantite'] ?>'></p>
				<p>Date achat : <input type='date' name='date_achat' value='<?php echo $data['date_achat'] ?>'></p>
				<p>Boire avant : <input type='date' name='date_buvable' value='<?php echo $data['date_buvable'] ?>'></p>
				<p>Prix : <input name='prix' value='<?php echo $data['prix'] ?>'></p>
				<p>Pays : <input name='pays' value='<?php echo $data['pays'] ?>'></p>
				<p>Format : <input name='format' value='<?php echo $data['leFormat'] ?>'></p>
				<p>Type : <input name='type' value='<?php echo $data['type'] ?>' disabled='disabled'></p>
				<p>Code SAQ : <input name='code_SAQ' value='<?php echo $data['code_SAQ'] ?>' disabled='disabled'></p>
				<input type='hidden' name='id' value='<?php echo $data['id_cellier_bouteille'] ?>'>
				<input type='hidden' name='requete' value='modifier'>
				<input type='submit' value='Modifier la bouteille'>
			</form>
			
		</div>
	</div>
</div>
