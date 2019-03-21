<main id='inscription' class='mdl-layout__content'>
	<div id='conteneurinscription' class='mdl-layout__tab-panel is-active'>
		<h2>Inscription</h2>
		<form method='POST' action='index.php?login&action=sinscrire'>
		Courriel : <input type='email' name='pseudo' placeholder='dupont@mail.com' required> <br><br>
		
		Nom : <input type='text' name='nom' placeholder='Nom' required><br><br>
		
		Prénom : <input type='text' name='prenom' placeholder='prénom' required><br><br>
		 
		Mot de passe : <input type='password' name='mdp' required><br><br>

		Confimation Mot de passe : <input type='password' name='mdp2' required><br><br>
		 
		<input type='submit' value='S’inscrire'>
	</form>
	<?php
	if (isset($donnees['erreurs'])) {
		if($donnees['erreurs'] != '')
			{
				echo '<p class="message"><i class="fas fa-exclamation"></i>' . $donnees['erreurs'] . '</p>';
			}
	}
	
	?>
	</div>
</main>