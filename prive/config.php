<?php
	// Définition des constantes
	define("RACINE", $_SERVER["DOCUMENT_ROOT"] . '/vinoPerso/prive/');
	define("BASEURL", 'http://localhost:8888/vinoPerso/www/');
	define("DBTYPE", 'mysql');
	define("HOST", 'localhost');
	define("DBNAME", 'vino');
	define("CHARSET", 'utf8mb4');
	define("USER", 'root');
	define("PWD", 'root');
	
	// Fonction d’autoload
	function my_autoloader($classe)
	{
		$repertoires = array(
			RACINE . 'controleurs/',
			RACINE . 'modeles/',
			RACINE . 'vues/'
		);

		foreach($repertoires as $rep)
		{
			if(file_exists($rep . $classe . '.php'))
			{
				require_once($rep . $classe . '.php');
				return;
			}
		}
	}

	spl_autoload_register('my_autoloader');


	// Action par défaut
	if (empty($_REQUEST['action']))
	{
		$_REQUEST['action'] = 'index';
	}
