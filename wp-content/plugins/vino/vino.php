<?php
/*
Plugin Name: Vino
Description: Gestion de celliers pouvant contenir des bouteilles de la Société des alcools du Québec (SAQ)
Version:     1.0
Author:      José Ignacio Delgado, Fatemeh Homatash, Alexandre Pachot et Charef Eddine Yagoubi
License:     CC BY-SA 3.0
License URI: https://creativecommons.org/licenses/by-sa/3.0/deed.fr
*/

// Activation de l’extension.
// register_activation_hook( __FILE__, "vino_activation");
// include ("vino-activation.php");

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define WC_PLUGIN_FILE.
if ( ! defined( 'VINO_FICHIER' ) ) {
	define( 'VINO_FICHIER', __FILE__ );
}

// Include the main WooCommerce class.
if ( ! class_exists( 'Vino' ) ) {
	include_once __DIR__ . '/inclut/classe-vino.php';
}

Vino::instance();
