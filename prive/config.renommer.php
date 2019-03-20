<?php
	// Définition des constantes

	// Pour le chargement automatique des classes
	define("RACINE", $_SERVER["DOCUMENT_ROOT"] . '/vino/prive/');

	// Pour le chargement du CSS, JS et images
	// Ce qui doit être directement accessible par le navigateur
	define("BASEURL", 'http://127.0.0.1/vino/www/');


	// Pour la connexion à la base de données
	define("DBTYPE", 'mysql'); // mysql ou oracle
	define("HOST", 'localhost');
	define("DBNAME", 'vino');
	define("CHARSET", 'utf8mb4');
	define("USER", 'root');
	define("PWD", '');
	

	// Fonction d’autoload
	function chargement_automatique_des_classes($classe)
	{
		$repertoires = array(
			RACINE . 'controleurs/',
			RACINE . 'modeles/',
			RACINE . 'vues/'
		);

		foreach($repertoires as $repertoire)
		{
			if(file_exists($repertoire . $classe . '.php'))
			{
				require_once($repertoire . $classe . '.php');
				return;
			}
		}
	}

	// Enregistre une fonction en tant qu’implémentation de __autoload()
	spl_autoload_register('chargement_automatique_des_classes');


	// Action par défaut
	if (empty($_REQUEST['action']))
	{
		$_REQUEST['action'] = 'index';
	}
