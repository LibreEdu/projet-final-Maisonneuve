<?php
/*
Plugin Name:	e1795854 TP1
Plugin URI:		https://e1795854.webdev.cmaisonneuve.qc.ca/TP1/
Description:	Développement d’une extension
Version:		1.0
Author:			Alexandre Pachot
Author URI:		https://e1795854.webdev.cmaisonneuve.qc.ca/
License:		GPL3
License URI:	https://www.gnu.org/licenses/gpl-3.0.html
*/


// Fonction de débogage.
//include ("e1795854_TP1_debug.php");

// Activation de l’extension.
register_activation_hook( __FILE__, "e1795854_TP1_activation");
include ("e1795854_TP1_rh_activation.php");

// Menu d’administration.
include ("e1795854_TP1_admin.php");

// Formulaire
include ("e1795854_TP1_form.php");

// Ajout d’une annonce  		: [e1795854_TP1_insertion].
include ("e1795854_TP1_sc_insertion.php");

// Liste des annonces 			: [e1795854_TP1_list].
include ("e1795854_TP1_sc_list.php");

// Détail de l’annonce			: [e1795854_TP1_detail].
include ("e1795854_TP1_sc_detail.php");

// Modification de l’annonce	: [e1795854_TP1_modification].
include ("e1795854_TP1_sc_modification.php");

// Suppression de l’annonce		: [e1795854_TP1_suppression].
include ("e1795854_TP1_sc_suppression.php");

// Désactivation de l’extension.
register_deactivation_hook( __FILE__, 'e1795854_TP1_deactivation' );
include ("e1795854_TP1_rh_deactivation.php");

// Désinstallation de l’extension.
register_uninstall_hook(__FILE__, "e1795854_TP1_uninstall");
include ("e1795854_TP1_rh_uninstall.php");

?>
