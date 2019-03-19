<?php

/**
 * Fichier de lancement du MVC, Il appel le var.init et le gabarit HTML 
 * @author Jonathan Martel
 * @author Alexandre Pachot
 * @version 1.0
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 */


 
	// /***************************************************/
	// /** Fichier de configuration, contient les define et l'autoloader **/
	// /***************************************************/
	// require_once('../prive/config/base_de_donnees.php');
	// require_once('../prive/config/chargement_automatique.php');
	
	// /***************************************************/
	// /** Initialisation des variables **/
	// /***************************************************/
	// require_once("../prive/config/var.init.php");

	// /***************************************************/
	// /** Démarrage du controleur **/
	// /***************************************************/
	// $oCtl = new Controler();
	// $oCtl->gerer();

	require_once('../privee/config.php');
	Routeur::route();
