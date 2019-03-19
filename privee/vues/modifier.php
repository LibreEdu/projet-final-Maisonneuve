<?php 
	$monURL = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
	$URLCoupee = strstr($monURL, '=');
	$URLCoupee = substr($URLCoupee, 1);
	$URLCoupee = strstr($URLCoupee, '&', true);
?>
<main class="mdl-layout__content">
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">
	<?php 					
		if($URLCoupee == "modifierBouteille") {
			echo '<div class="mdl-card__title">	
			<h2 class="mdl-card__title-text">Modifier une bouteille</h2>		
			</div>
			<div class="mdl-card__supporting-text">
				<form name="form" method="POST" onsubmit="return ValiderChamps(this)">
					<div class="mdl-textfield mdl-js-textfield">
						Nom : <input class="mdl-textfield__input" type="text" name="nom" value="'; echo $data['nom']; echo '">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Millesime : <input class="mdl-textfield__input" type="number" min="1900" max="'; echo date('Y'); echo '" name="millesime" value="'; echo $data['millesime']; echo '">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Quantité : <input class="mdl-textfield__input" type="number"  min="0" name="quantite" value="'; echo $data['quantite']; echo '">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Date d\'achat : <input class="mdl-textfield__input" type="date" name="date_achat" value="'; echo $data['date_achat']; echo '">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Boire avant : <input class="mdl-textfield__input" type="date" name="date_buvable" value="'; echo $data['date_buvable']; echo '">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Prix : <input class="mdl-textfield__input" type="text" name="prix" value="'; echo $data['prix']; echo '">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Pays : <input class="mdl-textfield__input" type="text" name="pays" value="'; echo $data['pays']; echo '">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Format : <input class="mdl-textfield__input" type="text" name="format" value="'; echo $data['leFormat']; echo '">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Type : <select name="type">';
							foreach ($type as $cle => $unType)
							{
								echo "<option value='" . $unType['id'] . "'>" . $unType['libelle'] . "</option>";
							}
						echo '</select>
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Notes : <input class="mdl-textfield__input" type="text" size="3" name="notes" value="'; echo $data['notes']; echo '">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Code SAQ : <input class="mdl-textfield__input" type="text" name="code_SAQ" value="'; echo $data['code_SAQ']; echo '" disabled="disabled">
					</div>
					<div>
						<input type="hidden" name="id" value="'; echo $data['id_cellier_bouteille']; echo '">
						<input type="hidden" name="requete" value="modifier">
						<input type="submit" value="Modifier la bouteille" class="mdl-button mdl-js-button mdl-button--raised">';
		} else {
			echo '<div class="mdl-card__title">	
			<h2 class="mdl-card__title-text">Ajouter une bouteille</h2>		
			</div>
			<div class="mdl-card__supporting-text">
				<form name="form" method="POST" onsubmit="return ValiderChamps(this)">
					<div class="mdl-textfield mdl-js-textfield">
						Nom : <input class="mdl-textfield__input" type="text" name="nom">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Millesime : <input class="mdl-textfield__input" type="number" min="1900" max="'; echo date('Y'); echo '" name="millesime">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Quantité : <input class="mdl-textfield__input" type="number"  min="0" name="quantite">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Date d\'achat : <input class="mdl-textfield__input" type="date" name="date_achat">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Boire avant : <input class="mdl-textfield__input" type="date" name="date_buvable">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Prix : <input class="mdl-textfield__input" type="text" name="prix">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Pays : <input class="mdl-textfield__input" type="text" name="pays">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Format : <input class="mdl-textfield__input" type="text" name="format">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Type : <select name="type">';
							foreach ($type as $cle => $unType)
							{
								echo "<option value='" . $unType['id'] . "'>" . $unType['libelle'] . "</option>";
							}
						echo '</select>
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Notes : <input class="mdl-textfield__input" type="text" size="3" name="notes">
					</div>
					<div>
						<input type="hidden" name="id" value="'; echo $data['id_cellier_bouteille']; echo '">
						<input type="hidden" name="requete" value="modifier">
						<input type="submit" value="Ajouter la bouteille" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">';
		}
				?>
			</div>
		</form>
	</div>
</main>
