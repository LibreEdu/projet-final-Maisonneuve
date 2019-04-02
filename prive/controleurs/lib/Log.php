<?php

/**
 * Permet d’écrire des fichiers de log.
 *
 * @package  Vino
 * @author   Alexandre Pachot
 * @version  1.0
 */
class Log
{
	/**
	 * @var string $_nom_fichier Nom du fichier de log ainsi que de son répertoire.
	 */
	private $_nom_fichier;


	/**
	 * Initialisation des attributs.
	 * 
	 * @param string $nom_fichier Nom du fichier de log
	 * 
	 * @return void
	 */
	public function __construct($nom_fichier)
	{
		$this->_nom_fichier = RACINE . 'logs/' . $nom_fichier . '.log';
	}


	/**
	 * Écriture dans le fichier de log.
	 * 
	 * @param string $message Message que l’on veut écrire dans le fichier de log.
	 * 
	 * @return void
	 */
	public function ecrire($message)
	{
		$date = new DateTime();
		$date = $date->format('r');
		error_log($date . '  ' . $message . "\n", 3, $this->_nom_fichier);
	}
}
