<div class="modifier">
 <div class="bouteille">
            <form name="form" method="POST" onsubmit="return ValiderChamps(this)">
                <p>Nom : <input name="nom" value="<?php echo $data['nom'] ?>"></p>
                <p>Millesime : <input type="number" min="1900" max="<?php echo date('Y'); ?>" name="millesime" value="<?php echo $data['millesime'] ?>"></p>
                <p>Quantite : <input type="number" min="0" name="quantite" value="<?php echo $data['quantite'] ?>"></p>
                <p>Date achat : <input type="date" name="date_achat" value="<?php echo $data['date_achat'] ?>"></p>
				<p>Boire avant : <input type="date" name="date_buvable" value="<?php echo $data['date_buvable'] ?>"></p>
                <p>Prix : <input name="prix" value="<?php echo $data['prix'] ?>"></p>
				<p>Pays : <input name="pays" value="<?php echo $data['pays'] ?>"></p>
				<p>Format : <input name="format" value="<?php echo $data['leFormat'] ?>"></p>
                <p>Type : <select name="type">
				<?php
					foreach ($type as $cle => $unType)
					{
						echo "<option value='" . $unType['id'] . "'>" . $unType['libelle'] . "</option>";
					}
				?>
				</select></p>
                <p>Notes : <textarea style="resize: none;" name="notes"><?php echo $data['notes'] ?></textarea></p>
				<p>Code SAQ : <input name="code_SAQ" value="<?php echo $data['code_SAQ'] ?>" disabled="disabled"></p>
				<input type="hidden" name="id" value="<?php echo $data['id_cellier_bouteille'] ?>">
				<input type="hidden" name="requete" value="modifier">
				<input type="submit" value="Modifier la bouteille">
            </form>
            
        </div>
    </div>
</div>
