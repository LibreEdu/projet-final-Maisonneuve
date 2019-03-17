<?php
/**
 * Réglage de Vino
 *
 * @package Vino\Classes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Classe principale de Vino.
 *
 * @class Vino
 */
final class Vino {

	/**
	 * La seule instance de la classe.
	 *
	 * @var Vino
	 */
	protected static $_instance = null;

	/**
	 * L’instance principale de Vino.
	 *
	 * S’assurer qu’une seule instance de Vino est chargée ou peut être chargée.
	 *
	 * @return Vino - Instance principale.
	 */
	public static function instance() {
		// Méthode pour avoir un singleton.
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Le constructeur de Vino.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->definir_constante();
		$this->inclut();
		$this->initialisation_crochet();
	}

	/**
	 * Définit la constante de Vino.
	 *
	 * @return void
	 */
	private function definir_constante() {
		$this->define( 'VINO_REPERTOIRE', dirname( VINO_FICHIER ) . '/' );
	}

	/**
	 * Définit une constante si elle n’est pas déjà définie.
	 *
	 * @param string      $nom    Nom de la constante.
	 * @param string|bool $valeur Valeur de la constante.
	 */
	private function define( $nom, $valeur ) {
		if ( ! defined( $nom ) ) {
			define( $nom, $valeur );
		}
	}

	/**
	 * Inclusion des fichiers de base requis utilisés pour l’interface d’administration et l’application frontale.
	 *
	 * @return void
	 */
	public function inclut() {
		include_once VINO_REPERTOIRE . 'inclut/classe-vino-installer.php';
		include_once VINO_REPERTOIRE . 'inclut/admin/classe-vino-admin.php';
	}

	/**
	 * Initialisation du crochet
	 *
	 * @return void
	 */
	private function initialisation_crochet() {
		register_activation_hook( VINO_FICHIER, array( 'Vino_Installer', 'verifie_version' ));
	}
}
