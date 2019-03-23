<main class="mdl-layout__content">
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">
		<?php 
			if(isset($donnees['bouteille'])){
				$bouteille = $donnees['bouteille'][0];
			}
			$nom          = isset($bouteille->nom) ? $bouteille->nom : '';
			$quantite     = isset($bouteille->quantite) ? $bouteille->quantite : '';
			$millesime    = isset($bouteille->millesime) ? $bouteille->millesime : '';
			$date_achat   = isset($bouteille->date_achat) ? $bouteille->date_achat : '';
			$boire_avant  = isset($bouteille->boire_avant) ? $bouteille->boire_avant : '';
			$prix         = isset($bouteille->prix) ? $bouteille->prix : '';
			$pays         = isset($bouteille->pays) ? $bouteille->pays : '';
			$format       = isset($bouteille->format) ? $bouteille->format : '';
			$note         = isset($bouteille->note) ? $bouteille->note : '';
			$id_bouteille = isset($bouteille->id_bouteille) ? $bouteille->id_bouteille : '';
		?>
		<div class="mdl-card__title">	
			<h2 class="mdl-card__title-text"><?php echo $donnees['titre'] ?></h2>		
		</div>
		<div class="mdl-card__supporting-text">
			<div class="mdl-textfield mdl-js-textfield" id="recherche">
				Recherche : <input class="mdl-textfield__input" type="text" name="nom_bouteille">
				<ul class="listeAutoComplete">

				</ul>
			</div>
			<div class="case">
				<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="afficher">
					<input type="checkbox" class="mdl-checkbox__input" name="recherche" id="afficher">
					<span class="mdl-checkbox__label">Faire une recherche dans les bouteilles de la SAQ</span>
				</label>
			</div>
			<form method="POST">				
				<div class="mdl-textfield mdl-js-textfield">
					Nom : 
					<!--<span data-id='' class='nom_bouteille'>-->
						<input class="mdl-textfield__input" type="text" id="nom_bouteille" name="nom" value="<?php echo $nom ?>" required="required">
						<!--<span class="mdl-textfield__error">Entrez le nom de la bouteille</span>-->
					<!--</span>-->
				</div>
				<div class="mdl-textfield mdl-js-textfield">
					Millesime :  
					<!--<span data-id='' class='millesime'>-->
						<input class="mdl-textfield__input" type="number" min="1900" max="<?php echo date('Y') ?>" id="millesime" name="millesime" value="<?php echo $millesime ?>">
					<!--</span>-->
				</div>
				<div class="mdl-textfield mdl-js-textfield" id="quantite">
					Quantité : <input class="mdl-textfield__input" type="number" min="0" name="quantite" value="<?php echo $quantite ?>">
				</div>
				<div class="mdl-textfield mdl-js-textfield" id="date_achat">
					Date d'achat : <input class="mdl-textfield__input" type="date" required="required" name="date_achat" value="<?php echo $date_achat ?>">
				</div>
				<div class="mdl-textfield mdl-js-textfield" id="boire_avant">
					Boire avant : <input class="mdl-textfield__input" type="date" required="required" name="boire_avant" value="<?php echo $boire_avant ?>">
				</div>
				<div class="mdl-textfield mdl-js-textfield">
					Prix :
					<!--<span data-id='' class='prix'>-->
						<input class="mdl-textfield__input" type="text" id="prix" name="prix" value="<?php echo $prix ?>">
					<!--</span>-->
				</div>
				<div class="mdl-textfield mdl-js-textfield">
					Pays :
					<!--<span data-id='' class='pays'> -->
						<input class="mdl-textfield__input" type="text" id="pays" name="pays" value="<?php echo $pays ?>">
					<!--</span>-->
				</div>
				<div class="mdl-textfield mdl-js-textfield">
					Format : 
					<!--<span data-id='' class='format'>-->
						<input class="mdl-textfield__input" type="text" id="format" name="format" value="<?php echo $format ?>">
					<!--</span>-->
				</div>
				<div class="mdl-textfield mdl-js-textfield">
					Type : <select name="type">
					<?php
						foreach ($donnees['types'] as $unType)
						{
							echo "<option value='" . $unType->id_type . "'>" . $unType->type . "</option>";
						}
					?>
					</select>
				</div>
				<div class="mdl-textfield mdl-js-textfield" id="note">
					Note : <input class="mdl-textfield__input" type="text" size="3" required="required" name="note" value="<?php echo $note ?>">
				</div>
				<div class="mdl-textfield mdl-js-textfield" id="cellier">
					Cellier : <select name="id_cellier">
					<?php
						foreach ($donnees['celliers'] as $unCellier)
						{
							echo "<option value='" . $unCellier->id_cellier . "'>" . $unCellier->nom . "</option>";
						}
					?>
					</select>
				</div>
				<div>
					<input type="hidden" name="id_bouteille" value="<?php echo $id_bouteille ?>">
					<input type="hidden" name="action" value="<?php echo $donnees['actionBouton'] ?>">
					<input type="submit" value="<?php echo $donnees['titreBouton'] ?>" class="mdl-button mdl-js-button mdl-button--raised">
				</div>
			</form>
	</div>
</main>
