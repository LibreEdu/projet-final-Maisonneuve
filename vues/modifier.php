<main class="mdl-layout__content">
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">
	<div class="mdl-card__title">
		<h2 class="mdl-card__title-text">Modifier une bouteille</h2>
	</div>
	<div class="mdl-card__supporting-text">
		<form name="form" method="POST" onsubmit="return ValiderChamps(this)">
			<div class="mdl-textfield mdl-js-textfield">
				Nom : <input class="mdl-textfield__input" type="text" name="nom" value="<?php echo $data['nom'] ?>">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Millesime : <input class="mdl-textfield__input" type="number" min="1900" max="<?php echo date('Y'); ?>" name="millesime" value="<?php echo $data['millesime'] ?>">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Quantité : <input class="mdl-textfield__input" type="number"  min="0" name="quantite" value="<?php echo $data['quantite'] ?>">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Date d'achat : <input class="mdl-textfield__input" type="date" name="date_achat" value="<?php echo $data['date_achat'] ?>">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Boire avant : <input class="mdl-textfield__input" type="date" name="date_buvable" value="<?php echo $data['date_buvable'] ?>">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Prix : <input class="mdl-textfield__input" type="text" name="prix" value="<?php echo $data['prix'] ?>">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Pays : <input class="mdl-textfield__input" type="text" name="pays" value="<?php echo $data['pays'] ?>">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Format : <input class="mdl-textfield__input" type="text" name="format" value="<?php echo $data['leFormat'] ?>">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Type : <select name="type">
				<?php
					foreach ($type as $cle => $unType)
					{
						echo "<option value='" . $unType['id'] . "'>" . $unType['libelle'] . "</option>";
					}
				?>
				</select>
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Notes : <input class="mdl-textfield__input" type="text" size="3" name="notes" value="<?php echo $data['notes'] ?>">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Code SAQ : <input class="mdl-textfield__input" type="text" name="code_SAQ" value="<?php echo $data['code_SAQ'] ?>" disabled="disabled">
			</div>
			<div>
				<input type="hidden" name="id" value="<?php echo $data['id_cellier_bouteille'] ?>">
				<input type="hidden" name="requete" value="modifier">
				<input type="submit" value="Modifier la bouteille" class="mdl-button mdl-js-button mdl-button--raised">
			</div>
		</form>
	</div>
</main>
