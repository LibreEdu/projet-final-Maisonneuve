<?php
	$usager = $_SESSION['id_usager'];
?>
<main class="mdl-layout__content">
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">		
		<div class="mdl-card__title">	
			<h2 class="mdl-card__title-text">Créer une liste d'achat</h2>		
		</div>
		<div class="mdl-card__supporting-text">
			<form name="form_achats" method="POST">
				<div class="mdl-textfield mdl-js-textfield">
					Nom de la liste d'achat : 
						<input class="mdl-textfield__input" type="text" id="nom_bouteille" name="nom" required="required">
				</div>
				<div id="mes_achats" class="mes_achats">			
				
				</div>
				<div class="mdl-textfield mdl-js-textfield">
					Faire une recherche dans les bouteilles de la SAQ : <input class="mdl-textfield__input" type="text" name="une_bouteille">
					<ul class="listeBouteilles">

					</ul>
				</div>				
				<div>
					<input type="hidden" name="action" value="ajouter_liste">
					<input type="hidden" name="id_usager" value="<?php echo $usager ?>">
					<input type="submit" value="Ajouter liste" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
				</div>
			</form>						
	</div>
</main>
