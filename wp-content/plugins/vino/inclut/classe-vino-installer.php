<?php
/**
 * Installation related functions and actions.
 *
 * @package WooCommerce/Classes
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * WC_Install Class.
 */
class Vino_Installer {

	/**
	 * Hook in tabs.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'verifie_version' ));
	}

	/**
	 * Check WooCommerce version and run the updater is required.
	 *
	 * This check is done on all requests and runs if the versions do not match.
	 */
	public static function verifie_version() {
		global $wp_version;
		if(version_compare($wp_version, '5', '>=')) { // Fonction PHP
			self::installer();
		}
	}

	/**
	 * Install WC.
	 */
	public static function installer() {
		if ( ! is_blog_installed() ) {
			return;
		}

		self::create_tables();
	}

	/**
	 * Set up the database tables which the plugin needs to function.
	 *
	 * Tables:
	 *      woocommerce_attribute_taxonomies - Table for storing attribute taxonomies - these are user defined
	 *      woocommerce_termmeta - Term meta table - sadly WordPress does not have termmeta so we need our own
	 *      woocommerce_downloadable_product_permissions - Table for storing user and guest download permissions.
	 *          KEY(order_id, product_id, download_id) used for organizing downloads on the My Account page
	 *      woocommerce_order_items - Order line items are stored in a table to make them easily queryable for reports
	 *      woocommerce_order_itemmeta - Order line item meta is stored in a table for storing extra data.
	 *      woocommerce_tax_rates - Tax Rates are stored inside 2 tables making tax queries simple and efficient.
	 *      woocommerce_tax_rate_locations - Each rate can be applied to more than one postcode/city hence the second table.
	 */
	private static function create_tables() {
		global $wpdb;

		$wpdb->hide_errors();

		require_once(ABSPATH . "wp-admin/includes/upgrade.php"); // Pour l’appel de la fonction dbDelta.

		dbDelta( self::get_schema() );

	}

	/**
	 * Get Table schema.
	 *
	 * @return string
	 */
	private static function get_schema() {
		global $wpdb;

		$charset_collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			$charset_collate = $wpdb->get_charset_collate();
		}

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
	 * Return a list of WooCommerce tables. Used to make sure all WC tables are dropped when uninstalling the plugin
	 * in a single site or multi site environment.
	 *
	 * @return array WC tables.
	 */
	public static function get_tables() {
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
	 * Drop WooCommerce tables.
	 *
	 * @return void
	 */
	public static function drop_tables() {
		global $wpdb;

		$tables = self::get_tables();

		foreach ( $tables as $table ) {
			$wpdb->query( "DROP TABLE IF EXISTS {$table}" ); // phpcs:ignore WordPress.WP.PreparedSQL.NotPrepared
		}
	}
}

Vino_Installer::init();
