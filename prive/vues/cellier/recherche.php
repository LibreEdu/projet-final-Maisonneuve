	<main class="mdl-layout__content">
		<div class="mdl-layout__tab-panel is-active" id="overview">
			<section class="section--center mdl-grid mdl-grid--no-spacing">				
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
					<button id="recherche" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
					  Rechercher
					</button>
					<div class="mdl-textfield mdl-js-textfield">
						Recherche par  
						<select id="recherchePar">
							<option value='' disabled selected style='display:none;'>-- selectionner --</option>
							<option value='millesime'>millesime</option>
							<option value='nom'>nom</option>
							<option value='pays'>pays</option>
							<option value='prix'>prix</option>	
							<option value='quantite'>quantite</option>							
							<option value='type'>type</option>
						</select>
						<select id="rechercheSpecifique" style='visibility: hidden;'>
							<option value='' disabled selected style='display:none;'>-- selectionner --</option>
							<option value=">=">plus grand ou égale</option>
							<option value="<=">plus petit ou égale</option>
						</select>
					</div>										
					<input class="mdl-textfield__input" type="search" id="btnRecherche" name="valeurRechercher" style="visibility: hidden;"/>	
					<ul class="affichageResultat"></ul>
				</div>
			</section>		  	
		</div>
	</main>

