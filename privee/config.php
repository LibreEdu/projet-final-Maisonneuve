<?php
	define("RACINE", $_SERVER["DOCUMENT_ROOT"] . '/vinocharef/privee/');
	define("BASEURL", 'http://localhost/vinocharef/www/');
	define("DBTYPE", 'mysql');
	define("DBNAME", 'vino');
	define("HOST", 'localhost');
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

	$_REQUEST['action'] = $_REQUEST['action'] ?? 'index';

?>