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
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'inclut' ) );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function inclut() {
		include_once VINO_REPERTOIRE . 'inclut/admin/classe-vino-admin-menu.php';
	}
}

return new Vino_Admin();
