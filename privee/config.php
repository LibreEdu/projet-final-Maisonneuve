<?php
	define("RACINE", $_SERVER["DOCUMENT_ROOT"] . '/vinoFatemeh/privee/');
	define("BASEURL", 'http://127.0.0.1/vinoFatemeh/www/');
	define("DBTYPE", 'mysql');
	define("HOST", 'localhost');
	define("DBNAME", 'vino');
	define("CHARSET", 'utf8mb4');
	define("USER", 'root');
	define("PWD", '');
	
	//définition de ma fonction d'autoload
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

	// $_REQUEST['action'] = $_REQUEST['action'] ?? 'index';
	if (empty($_REQUEST['action']))
	{
		$_REQUEST['action'] = 'index';
	}



?>