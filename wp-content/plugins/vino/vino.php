<?php
/**
 * Plugin Name: Vino
 * Plugin URI:  https://github.com/projetwebmaisonneuve/vino
 * Description: Gestion de celliers pouvant contenir des bouteilles de la Société des alcools du Québec (SAQ).
 * Version:     1.0
 * Author:      José Ignacio Delgado, Fatemeh Homatash, Alexandre Pachot et Charef Eddine Yagoubi
 * License:     CC BY-SA 3.0
 * License URI: https://creativecommons.org/licenses/by-sa/3.0/deed.fr
 *
 * @package Vino
 */

// Vérifie que la constante ABSPATH est définie.
// Cela permet d’empêcher l’accès direct au fichier.
// Si la première condition n’est pas remplie, alors on passe à la deuxième condition.
defined( 'ABSPATH' ) || exit;

// __FILE__ est une constante magique qui contient le chemin complet et le nom du fichier courant.
// Le premier paramètre de la fonction d’enregistrement des crochets d’activation (register_activation_hook)
// doit être le chemin du fichier principal de l’extension.
// C’est pour cela qu’on a besoin de cette constante.
// Si cette constante n’est pas définie alors on la définit.
defined( 'VINO_FICHIER' ) || define( 'VINO_FICHIER', __FILE__ );

// __DIR__ est une constante magique qui contient le nom du répertoire courant
// Si la classe Vino n’existe pas alors on l’inclut (chemin absolu).
class_exists( 'Vino' ) || include_once __DIR__ . '/inclut/classe-vino.php';

// Instanciation de la classe Vino
Vino::instance();
