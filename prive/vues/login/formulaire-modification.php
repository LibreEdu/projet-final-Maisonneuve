<main class="mdl-layout__content">
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">
		<?php 
			if(isset($donnees['usager'])){
				$usager = $donnees['usager'][0];
			}
			$courriel     = isset($usager->courriel) ? $usager->courriel : '';
			$nom          = isset($usager->nom) ? $usager->nom : '';
			$prenom       = isset($usager->prenom) ? $usager->prenom : '';
			$mot_de_passe       = isset($usager->mot_de_passe) ? $usager->mot_de_passe : '';
			$id_usager = isset($usager->id_usager) ? $usager->id_usager : '';
			//var_dump($id_usager);
		?>
		<div class="mdl-card__title">	
			<h2 class="mdl-card__title-text"><?php echo $donnees['titre'] ?></h2>
		</div>
		<div class="mdl-card__supporting-text">
			
			<form method="POST">				
				<div class="mdl-textfield mdl-js-textfield">
					Courriel : 
					<!--<span data-id='' class='nom_bouteille'>-->
						<input class="mdl-textfield__input" type="text" name="courriel" value="<?php echo $courriel ?>" required="required">
						<!--<span class="mdl-textfield__error">Entrez le nom de la bouteille</span>-->
					<!--</span>-->
				</div>
				<div class="mdl-textfield mdl-js-textfield">
					nom : 
					<!--<span data-id='' class='nom_bouteille'>-->
						<input class="mdl-textfield__input" type="text" name="nom" value="<?php echo $nom ?>" required="required">
						<!--<span class="mdl-textfield__error">Entrez le nom de la bouteille</span>-->
					<!--</span>-->
				</div>
				<div class="mdl-textfield mdl-js-textfield">
					prenom : 
					<!--<span data-id='' class='nom_bouteille'>-->
						<input class="mdl-textfield__input" type="text" name="prenom" value="<?php echo $prenom ?>" required="required">
						<!--<span class="mdl-textfield__error">Entrez le nom de la bouteille</span>-->
					<!--</span>-->
				</div>
				<div class="mdl-textfield mdl-js-textfield">
					Tapez votre ancien mot de passe : 
					<span data-id='' class='nom_bouteille'>
						<input class="mdl-textfield__input" type="password" name="mdp" value="" required="required">
						<span class="mdl-textfield__error">Entrez le nom de la bouteille</span>
					</span>
				</div>
				<div class="mdl-textfield mdl-js-textfield">
					Tapez votre nouveau mot de passe : 
					<!--<span data-id='' class='nom_bouteille'>-->
						<input class="mdl-textfield__input" type="password"  name="mdp2" value="" required="required">
						<!--<span class="mdl-textfield__error">Entrez le nom de la bouteille</span>-->
					<!--</span>-->
				</div>

					<div class="mdl-textfield mdl-js-textfield">
					Confirmer votre mot de passe : 
					<!--<span data-id='' class='nom_bouteille'>-->
						<input class="mdl-textfield__input" type="password" name="mdp3"  value="" required="required">
						<!--<span class="mdl-textfield__error">Entrez le nom de la bouteille</span>-->
					<!--</span>-->
				</div>
				
			
				<div>
					<?php
						if(isset($id_usager))
						{
					?>
					<input type="hidden" name="id_usager" value="<?php echo $id_usager ?>">
					<?php
						}
					?>
					<input type="hidden" name="action" value="<?php echo $donnees['actionBouton'] ?>">
					<input type="submit" value="<?php echo $donnees['titreBouton'] ?>" class="<?php echo $donnees['classeBouton'] ?>">
				</div>
			</form>
	</div>
</main>