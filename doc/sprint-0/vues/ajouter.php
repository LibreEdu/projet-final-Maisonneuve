<main class="mdl-layout__content">
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">
	<div class="mdl-card__title">
		<h2 class="mdl-card__title-text">Ajouter une bouteille</h2>
	</div>
	<div class="mdl-card__supporting-text">
			<div class="mdl-textfield mdl-js-textfield">
				Recherche : <input class="mdl-textfield__input" type="text" name="nom_bouteille">
				<ul class="listeAutoComplete">

				</ul>
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Nom : <span data-id="" class="nom_bouteille"></span>
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Millesime : <input class="mdl-textfield__input" type="number" min="1900" max="<?php echo date('Y'); ?>" name="millesime">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Quantité : <input class="mdl-textfield__input" type="number"  min="0" name="quantite" value="1">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Date d'achat : <input class="mdl-textfield__input" type="date" name="date_achat">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Prix : <input class="mdl-textfield__input" type="text" name="prix">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Boire avant : <input class="mdl-textfield__input" type="date" name="date_buvable">
			</div>
			<div class="mdl-textfield mdl-js-textfield">
				Notes : <input class="mdl-textfield__input" type="text" size="3" name="notes">
			</div>
			<div>
				<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" name="ajouterBouteilleCellier">Ajouter la bouteille</button>
			</div>
	</div>
</main>
