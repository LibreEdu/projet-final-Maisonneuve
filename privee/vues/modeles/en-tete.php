<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<meta name="description" content="Vino, mon cellier">
	<title>Vino &amp; plaisir</title>

	<!-- Add to homescreen for Chrome on Android -->
	<meta name="mobile-web-app-capable" content="yes">
	<link rel="icon" sizes="192x192" href="images/android-desktop.png">

	<!-- Add to homescreen for Safari on iOS -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-title" content="Material Design Lite">
	<link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

	<!-- Tile icon for Win8 (144x144 + tile color) -->
	<meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
	<meta name="msapplication-TileColor" content="#3372DF">
	<link rel="shortcut icon" href="images/favicon.png">

	<!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
	<!--
	<link rel="canonical" href="http://www.example.com/">
	-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.deep_purple-pink.min.css">
	<link rel="stylesheet" href="<?php echo BASEURL?>css/styles.css">

	<script src="<?php echo BASEURL?>js/main.js"></script>
	<script src="<?php echo BASEURL?>js/valider.js"></script>

	<style>
	#view-source {
		position: fixed;
		display: block;
		right: 0;
		bottom: 0;
		margin-right: 40px;
		margin-bottom: 40px;
		z-index: 900;
	}

	.demo-card-wide.mdl-card {
		width: 600px;
		margin: 0 auto;
	}
	.demo-card-wide > .mdl-card__title {
		color: #000;
		height: 100px;
		border-bottom: 2px solid lightgrey;
	}
	.demo-card-wide > .mdl-card__menu {
		color: #fff;
	}
	</style>
</head>
<body class="mdl-demo mdl-color--grey-100 mdl-color-text--grey-700 mdl-base">
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
	<header class="mdl-layout__header mdl-layout__header--scroll mdl-color--primary">
		<div class="mdl-layout--large-screen-only mdl-layout__header-row">
		</div>
		<div class="mdl-layout--large-screen-only mdl-layout__header-row">
		<h3>Vino &amp; plaisir</h3>
		</div>
		<div class="mdl-layout--large-screen-only mdl-layout__header-row">
		</div>
		<div class="mdl-layout__tab-bar mdl-js-ripple-effect mdl-color--primary-dark">
			<a href="?requete=accueil" class="mdl-layout__tab is-active">Mon cellier</a>
			<a href="?requete=ajouterBouteilleSaq" class="mdl-layout__tab is-active">Bouteille SAQ</a>
			<a href="?requete=listesCelliers" class="mdl-layout__tab is-active">Liste des celliers</a>

			<!-- <a href="?requete=ajouterNouvelleBouteilleCellier" class="mdl-layout__tab">Ajouter bouteille</a> -->
			<!--<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-shadow--4dp mdl-color--accent" id="add">
				<i class="material-icons" role="presentation">add</i>
				<span class="visuallyhidden">Add</span>
			</button>-->
		</div>
	</header>