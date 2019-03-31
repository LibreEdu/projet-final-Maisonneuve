<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Page d’administration de Vino">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		<title>Vino admin</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/material.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/vino-admin.css">
	</head>
	<body>
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
		<div class="vino-entete mdl-layout__header mdl-layout__header--waterfall">
			<div class="mdl-layout__header-row">
				<span class="vino-title mdl-layout-title">
					<img class="vino-logo-image" src="<?php echo base_url(); ?>images/vino-logo.png">
				</span>
				<!-- Ajoute un espace afin d’aligner la barre de navigation à droite, version ordinateur -->
				<div class="mdl-layout-spacer"></div>
				<!-- Barre de navigation -->
				<div class="vino-navigation-container">
					<nav class="vino-navigation mdl-navigation">
						<a class="mdl-navigation__link mdl-typography--text-uppercase" href="<?php echo site_url('login&action=logout'); ?>">Déconnexion</a>
					</nav>
				</div>
				<span class="vino-logo-cell mdl-layout-title">
					<img class="vino-logo-image" src="<?php echo base_url(); ?>images/vino-logo.png">
				</span>
			</div>
		</div>
		<div class="vino-drawer mdl-layout__drawer">
			<span class="mdl-layout-title">
				<img class="vino-logo-image" src="<?php echo base_url(); ?>images/vino-logo.png">
			</span>
			<nav class="mdl-navigation">
				<a class="mdl-navigation__link" href="<?php echo site_url('login&action=logout'); ?>">Déconnexion</a>
			</nav>
		</div>
		<div class="vino-content mdl-layout__content">
		<a name="haut_de_page"></a>
		<div class="vino-be-together-section mdl-typography--text-center">
			<div class="logo-font vino-slogan">Bonjour <?php echo $donnees['prenom'] ?></div>
			<div class="logo-font vino-sub-slogan">Bienvenue à Vino administration</div>
			<a href="#importation">
				<button class="vino-fab mdl-button mdl-button--colored mdl-js-button mdl-button--fab mdl-js-ripple-effect">
					<i class="material-icons">expand_more</i>
				</button>
			</a>
		</div>
		<div class="vino-screen-section mdl-typography--text-center">
			<a name="importation"></a>
			<div class="mdl-typography--display-1-color-contrast">Importation SAQ</div>
		</div>
		<footer class="vino-footer mdl-mega-footer">
				<div class="mdl-mega-footer--top-section">
					<div class="mdl-mega-footer--right-section">
						<a class="mdl-typography--font-light" href="#haut_de_page">
							Retourner en haut de la page
							<i class="material-icons">expand_less</i>
						</a>
					</div>
				</div>
				<div class="mdl-mega-footer--middle-section">
					<p class="mdl-typography--font-light">
						Contactez-nous pour sur 
						<a class="mdl-navigation__link" href="https://github.com/projet-web-Maisonneuve/vino" target="_blank">GitHub</a> 
						pour plus de fonctionnalités.
					</p>
				</div>
			</footer>
		</div>
		<script src="<?php echo base_url(); ?>js/material.js"></script>
	</body>
</html>
