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
		add_action( 'admin_menu', array( $this, 'admin_menu' ));
	}

	/**
	 * Ajout du menu d’administration.
	 */
	public function admin_menu() {
		add_menu_page(
			'Vino - administration',     // Balise title de la page des réglages
			'Vino',                      // Texte de menu de la page des réglages dans le menu latéral gauche
			'administrator',             // Capacité pour afficher cette page
			'vino',                      // Slug dans l’url de la page
			array( $this, 'admin_page' ) // Fonction d’affichage de la page
		);
	}

	/**
	 * Ajout du menu d’administration.
	 */
	public function admin_page() {
		?>
		<div class="wrap">
			<h2>Coucou</h2>
		</div>
		<?php
		
	}
}

return new Vino_Admin_Menu();
