<main id="inscription" class="mdl-layout__content">
	<div id="conteneurinscription" class="mdl-layout__tab-panel is-active">
		<h2>Inscription</h2>
		<form method="POST">
        Courriel : <input type="text" name="pseudo" placeholder="dupont@mail.com"> <br><br>
        
        Nom : <input type="text" name="nom" placeholder="Nom"><br><br>
		
		Prénom : <input type="text" name="prenom" placeholder="prénom"><br><br>
         
        Mot de passe : <input type="password" name="mdp"><br><br>

        Confimation Mot de passe : <input type="password" name="mdp2"><br><br>
         
        <input type="submit" value="S'inscrire">
        <input type="hidden" name="action" value="inscription">
    </form>
    <?php
    if (isset($donnees["erreurs"])) {
    	if($donnees["erreurs"] != "")
			{
				echo "<p class='message'><i class='fas fa-exclamation'></i>" . $donnees["erreurs"] . "</p>";
			}
    }
    
	?>
	</div>
</main>