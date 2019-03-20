<main id="login" class="mdl-layout__content">
	<div id="conteneurLogin" class="mdl-layout__tab-panel is-active">
		<?php
			// Si la variable session n'est pas remplie
			if(!isset($_SESSION["UserID"]))
			{
				// var_dump($_SESSION["UserID"]);
		?>
		<div id="formlogin" >
			<h1>Connexion</h1>
			<!-- Formulaire de connexion -->
			<form method="POST">
			Nom de l'utilisateur : <input type="text" name="user"/><br><br>
			Mot de passe : <input type="password" name="pass"/><br><br>
			<input type="submit" value="Login"/>
			<input type="hidden" name="action" value="login">
		</form>
		<a href="?usager&action=inscription">Créer un compte</a><br>
				
		<?php
			}
			// Si l'usager est déjà connecté
			else
			{
				// // On affiche le message
				// echo "<p>Vous êtes déjà connecté sous le nom " . $_SESSION["UserID"] ."   ". "</p><br>";
				// echo "<a href='?usager&action=Logout'>Se déconnecter</a>";
			}
			// On affiche le message
			if($donnees["erreurs"] != "")
			{
				echo "<p class='message'><i class='fas fa-exclamation'></i>" . $donnees["erreurs"] . "</p>";
			}
		?>
		</div>

	</div>
</main>