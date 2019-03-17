<?php
/**
 * Fonctions liées à l'installation.
 *
 * @package Vino\Classes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Vino_Installer Class.
 */
class Vino_Installer {

	/**
	 * Vérifie la version de WordPress et lance l’installation.
	 */
	public static function verifie_version() {
		global $wp_version;

		// On vérifie que WordPress est installé ainsi que sa version
		if( is_blog_installed() && version_compare($wp_version, '5', '>=') ) {
			self::creer_tables();
		}
	}

	/**
	 * Crée les tables nécessaires au plug-in.
	 *
	 * @return void
	 */
	private static function creer_tables() {
		global $wpdb;

		$wpdb->hide_errors();

		// Pour pouvoir appeler dbDelta.
		require_once(ABSPATH . "wp-admin/includes/upgrade.php");

		// Création de nouvelles tables ou modification de la structure.
		dbDelta( self::obtenir_schema() );
	}

	/**
	 * Obtenir le schéma des tables.
	 *
	 * Tables:
	 *   vino_type - Table contenant les types de vin (Vin rouge, vin blanc…)
	 *   vino_bouteille_saq - Table destinée à stocker la liste des bouteilles de la SAQ.
	 *   vino_cellier - Table contenant les données relatives au cellier.
	 *   vino_bouteille - Table contenant les bouteilles contenues dans les celliers.
	 * @return string
	 */
	private static function obtenir_schema() {
		global $wpdb;

		$charset_collate = $wpdb->has_cap( 'collation' ) ? $charset_collate = $wpdb->get_charset_collate() : '';

		$tables = "
CREATE TABLE {$wpdb->prefix}vino_type (
	id_type tinyint unsigned NOT NULL auto_increment,
	type varchar(20) NOT NULL,
	PRIMARY KEY  (id_type)
) $charset_collate;
CREATE TABLE {$wpdb->prefix}vino_bouteille_saq (
	id_bouteille_saq bigint(20) unsigned NOT NULL auto_increment,
	code_saq char(8) NOT NULL,
	prix decimal(7,2) unsigned NOT NULL,
	millesime smallint(4) unsigned DEFAULT NULL,
	id_type tinyint unsigned NOT NULL,
	pays varchar(30) NOT NULL,
	format varchar(10) NOT NULL,
	nom varchar(200) NOT NULL,
	PRIMARY KEY  (id_bouteille_saq),
	FOREIGN KEY (id_type) REFERENCES {$wpdb->prefix}vino_type(id_type)
) $charset_collate;
CREATE TABLE {$wpdb->prefix}vino_cellier (
	id_cellier bigint(20) unsigned NOT NULL auto_increment,
	id_usager bigint(20) unsigned NOT NULL,
	nom varchar(30) NOT NULL,
	PRIMARY KEY  (id_cellier),
	FOREIGN KEY (id_usager) REFERENCES {$wpdb->prefix}users(ID)
) $charset_collate;
CREATE TABLE {$wpdb->prefix}vino_bouteille (
	id_bouteille bigint(20) unsigned NOT NULL auto_increment,
	id_cellier bigint(20) unsigned NOT NULL,
	code_saq char(8) NOT NULL,
	prix decimal(7,2) unsigned NOT NULL,
	millesime smallint(4) unsigned DEFAULT NULL,
	id_type tinyint unsigned NOT NULL,
	pays varchar(30) NOT NULL,
	format varchar(10) NOT NULL,
	nom varchar(200) NOT NULL,
	note text DEFAULT NULL,
	quantite smallint(5) NOT NULL,
	date_achat date DEFAULT NULL,
	PRIMARY KEY  (id_bouteille),
	FOREIGN KEY (id_cellier) REFERENCES {$wpdb->prefix}vino_cellier(id_cellier),
	FOREIGN KEY (id_type) REFERENCES {$wpdb->prefix}vino_type(id_type)
) $charset_collate;
		";

		return $tables;
	}

	/**
	 * Renvoie une liste de tables afin de pouvoir les supprimer lors de la désinstallation de l’extension.
	 *
	 * @return array Liste des tables Vino
	 */
	public static function obtenir_tables() {
		global $wpdb;

		$tables = array(
			"{$wpdb->prefix}vino_bouteille",
			"{$wpdb->prefix}vino_cellier",
			"{$wpdb->prefix}vino_bouteille_saq",
			"{$wpdb->prefix}vino_type",
		);

		return $tables;
	}

	/**
	 * Supprime les tables Vino
	 *
	 * @return void
	 */
	public static function supprimer_tables() {
		global $wpdb;

		$tables = self::obtenir_tables();

		foreach ( $tables as $table ) {
			$wpdb->query( "DROP TABLE IF EXISTS {$table}" );
		}
	}
}
