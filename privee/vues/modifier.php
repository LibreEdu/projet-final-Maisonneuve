<main class="mdl-layout__content">
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">
	<?php 
			$nom = isset($bouteille->nom) ? $bouteille->nom : '';
			$quantite = isset($bouteille->quantite) ? $bouteille->quantite : '';
			$millesime = isset($bouteille->millesime) ? $bouteille->millesime : '';
			$date_achat = isset($bouteille->date_achat) ? $bouteille->date_achat : '';
			$boire_avant = isset($bouteille->boire_avant) ? $bouteille->boire_avant : '';
			$prix = isset($bouteille->prix) ? $bouteille->prix : '';
			$pays = isset($bouteille->pays) ? $bouteille->pays : '';
			$format = isset($bouteille->format) ? $bouteille->format : '';
			$note = isset($bouteille->note) ? $bouteille->note : '';
			$id_bouteille = isset($bouteille->id_bouteille) ? $bouteille->id_bouteille : '';
	?>
			<div class="mdl-card__title">	
			<h2 class="mdl-card__title-text"><?php echo $data['titre'] ?></h2>		
			</div>
			<div class="mdl-card__supporting-text">
			<div class="mdl-textfield mdl-js-textfield">
				Recherche : <input class="mdl-textfield__input" type="text" name="nom_bouteille">
				<ul class="listeAutoComplete">

				</ul>
			</div>
				<form name="form" method="POST" onsubmit="return ValiderChamps(this)">
					<div class="mdl-textfield mdl-js-textfield">
						Nom : <input class="mdl-textfield__input" type="text" name="nom" value="<?php echo $nom ?>">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Millesime : <input class="mdl-textfield__input" type="number" min="1900" max="<?php echo date('Y') ?>" name="millesime" value="<?php echo $millesime ?>">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Quantité : <input class="mdl-textfield__input" type="number"  min="0" name="quantite" value="<?php echo $quantite ?>">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Date d\'achat : <input class="mdl-textfield__input" type="date" name="date_achat" value="<?php echo $date_achat ?>">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Boire avant : <input class="mdl-textfield__input" type="date" name="date_buvable" value="<?php echo $boire_avant ?>">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Prix : <input class="mdl-textfield__input" type="text" name="prix" value="<?php echo $prix ?>">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Pays : <input class="mdl-textfield__input" type="text" name="pays" value="<?php echo $pays ?>">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Format : <input class="mdl-textfield__input" type="text" name="format" value="<?php echo $format ?>">
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Type : <select name="type">
						<?php
							foreach ($data['types'] as $unType)
							{
								echo "<option value='" . $unType->id_type . "'>" . $unType->type . "</option>";
							}
						?>
						</select>
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						Note : <input class="mdl-textfield__input" type="text" size="3" name="note" value="<?php echo $note ?>">
					</div>
					<div>
						<input type="hidden" name="id" value="<?php echo $id_bouteille ?>">
						<input type="hidden" name="requete" value="<?php echo $data['actionBouton'] ?>">
						<input type="submit" value="<?php echo $data['titreBouton'] ?>" class="mdl-button mdl-js-button mdl-button--raised">
	<?php
		//}
	?>
			</div>
		</form>
	</div>
</main>
