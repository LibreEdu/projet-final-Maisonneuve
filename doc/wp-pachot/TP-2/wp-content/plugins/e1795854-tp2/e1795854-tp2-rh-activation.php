<?php

/** Activation de l’extension. */


/**
 * Traitements à l’activation de l’extension.
 *
 * @param void
 * @return void
 */
function e1795854_tp2_activation()
{
    e1795854_tp2_check_version();                               // Vérification de la version WP
    e1795854_tp2_create_table();                                // Création de la table des annonces
}


/**
 * Vérification de la version WP
 *
 * @param void
 * @return void
 */
function e1795854_tp2_check_version()
{
    global $wp_version;
    if(version_compare($wp_version, "4.9.8"))                   // Fonction PHP
        wp_die("Cette extension requiert WordPress version 4.9.8 ou plus.");
}


/**
 * Création de la table pour les vernissages
 *
 * @param void
 * @return void
 */
function e1795854_tp2_create_table()
{
    global $wpdb;
    $sql = "CREATE TABLE $wpdb->prefix"."vernissage (
        ID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
        first_name varchar(50) NOT NULL,
        last_name varchar(50) NOT NULL,
        email varchar(100) NOT NULL UNIQUE,
        post_id bigint UNSIGNED NOT NULL,
        PRIMARY KEY (ID),
        FOREIGN KEY (post_id) REFERENCES $wpdb->prefix"."posts(ID)
    ) ".$wpdb->get_charset_collate();                           // Jeu de caractères utilisé pour l’encodage.
    require_once(ABSPATH . "wp-admin/includes/upgrade.php");    // Pour l’appel de la fonction dbDelta.
    dbDelta($sql);                                              // Création d’une nouvelle table ou modification de sa structure.
}
