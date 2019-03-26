<main class="mdl-layout__content">
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">		
		<div class="mdl-card__title">	
			<h2 class="mdl-card__title-text">Mes listes d'achat</h2>		
		</div>
		<div class="mdl-card__supporting-text">
			<div class="mdl-textfield mdl-js-textfield">
				Faire une recherche dans les bouteilles de la SAQ : <input class="mdl-textfield__input" type="text" name="une_bouteille">
				<ul class="listeBouteilles">

				</ul>
			</div>
			<div id="mes_achats">				
				<div>
					<input type="hidden" name="action" value="ajouter-liste">
					<input type="submit" value="Ajouter liste" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
				</div>
			</div>
	</div>
</main>
