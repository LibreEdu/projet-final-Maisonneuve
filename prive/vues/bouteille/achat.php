<main class="mdl-layout__content">
	<div class="demo-card-wide mdl-card mdl-shadow--2dp">		
		<div class="mdl-card__title">	
			<h2 class="mdl-card__title-text">Mes listes d'achat</h2>		
		</div>
		<div id="listes_achat" class="mdl-card__supporting-text">
			<?php 
				if(isset($donnees['noms']) && $donnees['noms'] != null) {
					foreach ($donnees['noms'] as $nom_liste): 
						echo "<div class='nom_liste'>
								<input type='hidden' name='le_nom' value='".$nom_liste->id_liste_achat."'>
								<table style='width:100%;'>
									<tr>
										<td style='width:90%;'>
											<h5><a name='nom_liste' class='lien' href='index.php?liste_achat&action=details_liste_achat&nom=".$nom_liste->nom."'>".$nom_liste->nom."</a></h5>
										</td>
										<td style='width:10%;'>
										<button name='btnSupprimerListe' class='mdl-button mdl-js-button mdl-button--raised'><i class='far fa-trash-alt'></i></button>
										</td>
									<tr>
								</table>
							</div>";
					endforeach; 
				}
				else { 
					echo "<div>
							<h5 style='text-align: center; margin-bottom: 30px;'>Aucune liste à afficher</h5>
						</div>";
				} 
			?>	
			<div class="bouton">
				<p><a class="lien" href="index.php?liste_achat&action=liste_form">Créer une liste d'achat</a></p>
			</div>
		</div>
	</div>
<!-- </main> -->
<script type="text/javascript">
		window.addEventListener("load", function(){
			document.getElementById("listes_achat").classList.add("active");
			document.getElementById("cellier").classList.remove("active");
			document.getElementById("moncompte").classList.remove("active");
	},  false)
</script>