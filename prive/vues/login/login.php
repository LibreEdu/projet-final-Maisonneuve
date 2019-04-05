			<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
			<main id='inscription'>
				<article class="card-body mx-auto" style="max-width: 400px;">
				<?php
					// Si la variable session n'est pas remplie
					if(!isset($_SESSION["UserID"]))
					{
				?>
					<h4 class="card-title mt-3 text-center">Connectez-vous à votre compte Vino</h4>
					<form method="POST" action="index.php?login">
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
							</div>
							<input name="courriel" class="form-control" placeholder="Dupont@mail.com" type="email" required>
						</div>
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
							</div>
							<input name="mot_de_passe" class="form-control" placeholder="Mot de passe" type="password">
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block"> Se connecter </button>
						</div>
						<p class="text-center">Vous n'avez pas de compte ? <a href="index.php?login&action=formulaire">Créer un compte</a> </p> 
					</form>
				<?php
					}
					
					// Gestion des erreurs
					if (isset($donnees['erreurs'])) 
					{
						if($donnees['erreurs'] != '')
							{
								echo '<p class="message"><i class="fas fa-exclamation"></i>' . $donnees['erreurs'] . '</p>';
							}
					}
					
				?>
				</article>
				<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
			</main>
