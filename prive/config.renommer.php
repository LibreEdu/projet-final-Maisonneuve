<?php
/**
 * @package  Vino
 */

	/**
 * Racine du répertoire PHP.
 * Pour le chargement automatique des classes.
 */
define('RACINE', $_SERVER['DOCUMENT_ROOT'] . '/../prive/');


/**
 * URL de la racine du site.
 * Cette URL est nécessaire pour le chargement du CSS, JS et images :
 * en bref, tout ce qui doit être directement accessible par le navigateur.
 */
define('BASEURL', 'http://127.0.0.1/');


/**
 * Type de base de données.
 * Nous avons le choix entre mysql et oracle.
 */
define('DBTYPE', 'mysql'); // mysql ou oracle


/**
 * Adresse du serveur contenant la base de données.
 */
define('HOST', 'localhost');


/**
 * Nom de la base de données.
 */
define('DBNAME', 'vino');


/** 
 * Jeu de caractères utilisé pour l’encodage des données.
 */
define('CHARSET', 'utf8mb4');


/** 
 * Nom d’utilisateur de la base de données.
 */
define('USERNAME', 'root');


/** 
 * Mot de passe de la base de données.
 */
define('PASSWD', '');


/**
 * Fonction de chargement automatique des classes.
 * 
 * @param object $classe Classe que l’on veut charger dynamiquement
 * 
 * @return void
 */
function chargement_automatique_de_la_classe($classe)
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
spl_autoload_register('chargement_automatique_de_la_classe');


// Action par défaut
if (empty($_REQUEST['action']))
{
	$_REQUEST['action'] = 'index';
}
