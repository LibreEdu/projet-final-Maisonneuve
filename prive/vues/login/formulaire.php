<!-- Page d'affichage du Formulaire  d'inscription -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">


<main id='inscription'>
<div class="card bg-light">
<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Créer un compte</h4>
	<p class="divider-text">
	</p>
	<!----- Le formulaire avec validation des champs html et php dans le contrôleur ----->
	<form method='POST' action='index.php?login&action=inscrire'>

	<div class="form-group input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
		 </div>
		<input name="courriel" class="form-control" placeholder="Dupont@mail.com" type="email" required>
	</div> 
	<div class="form-group input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> <i class="fa fa-user"></i> </span>
		</div>
		<input name="nom" class="form-control" placeholder="Nom" type="text"  pattern="[a-zA-ZàâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ\s-]+" required>		
	</div>

	<div class="form-group input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> <i class="fa fa-user"></i> </span>
		 </div>
		<input name="prenom" class="form-control" placeholder="Prénom" type="text"  pattern="[a-zA-ZàâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ\s-]+" required>
	</div>
	<span>Le mot de passe doit avoir entre 6 et 12 caractères</span>
	<div class="form-group input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
		<input name="mdp" class="form-control" placeholder="Mot de passe" type="password">
	</div>
	<div class="form-group input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
		<input name="mdp2" class="form-control" placeholder="Confirmer mot de passe" type="password">
	</div> <!-- form-group// -->
	<div class="form-group">
		<button type="submit" class="btn btn-primary btn-block"> S’inscrire </button>
	</div> <!-- form-group// -->

	</form>
	<!-- Récupération des messages d'erreurs -->
	<?php
		if (isset($donnees['erreurs']))
		{
			if($donnees['erreurs'] != '')
				{
					echo '<p class="message"><i class="fas fa-exclamation"> </i>' . $donnees['erreurs'] . '</p>';
				}
		}
		
	?>
</article>
</div> 
</main>