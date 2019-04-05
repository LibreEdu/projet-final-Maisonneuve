	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.purple-deep_purple.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/vino.css">	
	<script src="<?php echo base_url(); ?>js/valider.js"></script>
</head>
<body class="mdl-demo mdl-color--grey-100 mdl-color-text--grey-700 mdl-base">
<div class="demo-layout-transparent mdl-layout mdl-js-layout">
	<header  class="mdl-layout__header mdl-layout__header--transparent">
		
		<div class="mdl-layout__header-row">
			<a class="mdl-navigation__link" href="index.php?cellier"><span class="mdl-layout-title">Vino Veritas</span></a>
			<div class="mdl-layout-spacer"></div>
			<div class="mdl-layout-spacer"></div>
			<nav class="mdl-navigation">
				<a class="mdl-navigation__link active" id="cellier"href="index.php?Cellier">Mes celliers</a>
				<a class="mdl-navigation__link" id="listes_achat" href="index.php?liste_achat&action=listes_achat">Listes d'achat</a>
				<a id="moncompte" class="mdl-navigation__link" href="index.php?login&action=formulaireModification&id=<?php echo $_SESSION['id_usager'] ?>">Mon Compte</a>
				<a id="deconnexion" class="mdl-navigation__link" href="index.php?login&action=logout">Déconnexion</a>
			</nav>
		</div>
	</header>
	<div class="mdl-layout__drawer">
		<span class="mdl-layout-title">Vino Veritas</span>
		<nav class="mdl-navigation">
			<a class="mdl-navigation__link" href="index.php?Cellier">Mes celliers</a>
			<a class="mdl-navigation__link" href="index.php?liste_achat&action=listes_achat">Listes d'achat</a>
			<a id="moncompte" class="mdl-navigation__link" href="index.php?login&action=formulaireModification&id=<?php echo $_SESSION['id_usager'] ?>">Mon Compte</a>
			<a id="deconnexion" class="mdl-navigation__link" href="index.php?login&action=logout">Déconnexion</a>
		</nav>
	</div>