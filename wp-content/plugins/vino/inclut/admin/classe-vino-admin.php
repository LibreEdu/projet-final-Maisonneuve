<?php
/**
 * Vino Admin
 *
 * @class    Vino_Admin
 * @package  Vino\Admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Vino_Admin class.
 */
class Vino_Admin {

	/**
	 * Constructeur
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'inclut' ) );
	}

	/**
	 * Inclut toutes les classes nécessaires à l'administration.
	 */
	public function inclut() {
		include_once VINO_REPERTOIRE . 'inclut/admin/classe-vino-admin-menu.php';
	}
}

return new Vino_Admin();
