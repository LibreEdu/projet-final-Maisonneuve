<div class="modifier">
<?php
	foreach ($data as $cle => $bouteille) { 
?>
    <div class="bouteille">
            <div >
				<input type="hidden" name="id" value="<?php echo $bouteille['id_cellier'] ?>">
                <p>Nom : <input name="nom" value="<?php echo $bouteille['nom'] ?>"></p>
                <p>Millesime : <input name="millesime" value="<?php echo $bouteille['millesime'] ?>"></p>
                <p>Quantite : <input name="quantite" value="<?php echo $bouteille['quantite'] ?>"></p>
                <p>Date achat : <input type="date" name="date_achat" value="<?php echo $bouteille['date_achat'] ?>"></p>
                <p>Prix : <input name="prix" value="<?php echo $bouteille['prix'] ?>"></p>
                <p>Garde : <input name="garde_jusqua" value="<?php echo $bouteille['garde_jusqua'] ?>"></p>
                <p>Notes : <input name="notes" value="<?php echo $bouteille['notes'] ?>"></p>
				<p>Code SAQ : <input name="code_saq" value="<?php echo $bouteille['code_saq'] ?>" disabled="disabled"></p>
				<p>Prix SAQ : <input name="prix_saq" value="<?php echo $bouteille['prix_saq'] ?>" disabled="disabled"></p>
				<p>Pays : <input name="pays" value="<?php echo $bouteille['pays'] ?>"></p>
				<p>Déscription : <textarea style="resize: none;" name="description"><?php echo $bouteille['description'] ?></textarea></p>
				<p>Format : <input name="format" value="<?php echo $bouteille['format'] ?>"></p>
				<p>Type : <select name="type">
				<?php
					foreach ($type as $cle => $unType)
					{
						echo "<option value='" . $unType["id"] . "'>" . $unType["type"] . "</option>";
					}
				?>
				</select></p>
            </div>
            <button name="modifierBouteilleCellier">Modifier la bouteille</button>
        </div>
    </div>
<?php
}
?>
</div>
