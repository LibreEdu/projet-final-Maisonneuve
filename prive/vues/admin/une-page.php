<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Page d’administration de Vino">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		<title>Vino admin</title>
		<link rel="stylesheet" href="<?php echo base_url(); ?>fonts/iconfont/material-icons.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/material.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/vino-admin.css">
	</head>
	<body>
		<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
			<div class="vino-entete mdl-layout__header mdl-layout__header--waterfall">
				<div class="mdl-layout__header-row">
					<span class="vino-titre mdl-layout-title">
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
			<div class="vino-lateral mdl-layout__drawer">
				<span class="mdl-layout-title">
					<img class="vino-logo-image" src="<?php echo base_url(); ?>images/vino-logo-blanc.png">
				</span>
				<nav class="mdl-navigation">
					<a class="mdl-navigation__link" href="<?php echo site_url('login&action=logout'); ?>">Déconnexion</a>
				</nav>
			</div>
			<div class="vino-content mdl-layout__content">
				<a name="haut_de_page"></a>
				<div class="vino-section-bienvenue mdl-typography--text-center">
					<div class="vino-bienvenue-police vino-bonjour">Bonjour <?php echo $donnees['prenom'] ?></div>
					<div class="vino-bienvenue-police vino-bienvenue">Bienvenue sur Vino administration</div>
					<a href="#importation">
						<button class="vino-fab mdl-button mdl-button--colored mdl-js-button mdl-button--fab mdl-js-ripple-effect">
							<i class="material-icons">expand_more</i>
						</button>
					</a>
				</div>
				<div class="vino-importation-section">
					<div class="vino-importation-titre mdl-typography--text-center">
						<a name="importation"></a>
						<div class="mdl-typography--display-1-color-contrast">Importation SAQ</div>
					</div>
					<div class="vino-carte-importation mdl-card mdl-shadow--2dp">
						<div class="mdl-card__title mdl-card--expand"></div>
						<div class="mdl-card__supporting-text">
							Êtes-vous sûr de vouloir importer <?php echo $donnees['nbBouteillesWeb'] ?> bouteilles du site de la SAQ ?<br>
							Cela mettra à jour les <?php echo $donnees['nbBouteillesBD'] ?> bouteilles de la base de données.
						</div>
						<div class="mdl-card__actions mdl-card--border">
							<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="btnImporter">
								Importer les données du site de la SAQ
							</a>
						</div>
					</div>
				</div>
				<footer class="vino-piedpage mdl-mega-footer">
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
							Contactez-nous sur 
							<a class="mdl-navigation__link" href="https://github.com/projet-web-Maisonneuve/vino" target="_blank">GitHub</a> 
							pour plus de fonctionnalités.
						</p>
					</div>
				</footer>
			</div>
		</div>
		<script src="<?php echo base_url(); ?>js/material.js"></script>
		<script src="<?php echo base_url(); ?>js/vino-admin.js"></script>
		<script src="<?php echo base_url(); ?>js/vino-admin-module.js"></script>
	</body>
</html>
