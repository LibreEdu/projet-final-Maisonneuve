<?php
/*
Plugin Name:    e1795854 TP2
Plugin URI:     https://e1795854.webdev.cmaisonneuve.qc.ca/TP2/
Description:    Type de post personnalisé
Version:        1.0
Author:         Alexandre Pachot
Author URI:     https://e1795854.webdev.cmaisonneuve.qc.ca/
License:        GPL3
License URI:    https://www.gnu.org/licenses/gpl-3.0.html
*/



// Type de de post personnalisé.
include ("e1795854-tp2-aa-tpp.php");

// Champs personnalisés
include ("e1795854-tp2-aa-champs-personnalises.php");

// Traductions.
include ("e1795854-tp2-aa-translate.php");

// Activation de l’extension.
register_activation_hook( __FILE__, "e1795854_tp2_activation");
include ("e1795854-tp2-rh-activation.php");

// Formulaire vernissage : [e1795854_tp2_preview].
include ("e1795854-tp2-sc-preview.php");

// Liste des inscrits    : [e1795854_tp2_registered].
include ("e1795854-tp2-sc-registered.php");
