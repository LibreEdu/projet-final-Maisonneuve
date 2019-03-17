<?php
/**
 * Mise en place du menu d’administration
 *
 * @package Vino\Admin
 */

defined( 'ABSPATH' ) || exit;


/**
 * Vino_Admin_Menu Class.
 */
class Vino_Admin_Menu {

	/**
	 * Crochet.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'reglages_init' ) );
	}

	/**
	 * Ajout du menu d’administration.
	 */
	public function admin_menu() {
		add_menu_page(
			'Vino admin',                   // Balise title de la page des réglages
			'Vino',                         // Texte de menu de la page des réglages dans le menu latéral gauche
			'administrator',                // Capacité pour afficher cette page
			'vino',                         // Slug dans l’url de la page
			array( $this, 'admin_page' )    // Fonction d’affichage de la page
		);
	}

	/**
	 * Initialisation du formulaire.
	 */
	public function reglages_init() {
		register_setting(
			'vino_import_nb_bouteilles',                            // Nom de la zone dans le formulaire
			'vino_import',                                          // Nom de l’option de réglage
			array( $this, 'vino_import_nb_bouteilles_nettoyer' )    // Fonction pour nettoyer les options de réglage
		);
	}

	/**
	 * Nettoyage de la valeurs renvoyée par le formulaire.
	 */
	public function vino_import_nb_bouteilles_nettoyer($entree) {
		$entree['nb_bouteilles'] = sanitize_text_field($entree['nb_bouteilles']);
		return $entree;
	}

	/**
	 * Ajout du menu d’administration.
	 */
	public function admin_page() {
		// Récupération des options
		$options = get_option('vino_import');

		// Initialisation des variables du formulaire
		$nb_bouteilles  = $options['nb_bouteilles'] ?? '';

		// Formulaire
		include_once __DIR__ . '/vues/html-admin-page.php';
	}
}

return new Vino_Admin_Menu();
