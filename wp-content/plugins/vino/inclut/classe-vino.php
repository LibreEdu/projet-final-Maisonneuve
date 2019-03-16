<?php
/**
 * WooCommerce setup
 *
 * @package WooCommerce
 * @since   3.2.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main WooCommerce Class.
 *
 * @class WooCommerce
 */
final class Vino {

	/**
	 * The single instance of the class.
	 *
	 * @var WooCommerce
	 * @since 2.1
	 */
	protected static $_instance = null;

	/**
	 * Main WooCommerce Instance.
	 *
	 * Ensures only one instance of WooCommerce is loaded or can be loaded.
	 *
	 * @return Vino - Instance principale.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 2.1
	 */
	public function __clone() {
		trigger_error('Clonage interdit.', E_USER_ERROR);
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 2.1
	 */
	public function __wakeup() {
		trigger_error('La désérialisation de l’instances de cette classe est interdite.', E_USER_ERROR);
	}

	/**
	 * WooCommerce Constructor.
	 */
	public function __construct() {
		$this->definir_constante();
		$this->inclut();
		$this->initialisation_crochet();
	}

	/**
	 * Define WC Constants.
	 */
	private function definir_constante() {
		$this->define( 'VINO_REPERTOIRE', dirname( VINO_FICHIER ) . '/' );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}
	
	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function inclut() {
		/**
		 * Classe de base
		 */
		include_once VINO_REPERTOIRE . 'inclut/classe-vino-installer.php';
	}

	/**
	 * Hook into actions and filters.
	 */
	private function initialisation_crochet() {
		register_activation_hook( VINO_FICHIER, array( 'Vino_Installer', 'installer' ));
	}
}
