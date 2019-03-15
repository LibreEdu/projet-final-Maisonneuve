<?php

/** Activation de l’extension. */


/**
 * Traitements à l’activation de l’extension.
 *
 * @param void
 * @return void
 */
function e1795854_TP1_activation()
{
    e1795854_TP1_check_version();                               // Vérification de la version WP
    e1795854_TP1_create_table();                                // Création de la table des annonces
    e1795854_TP1_create_pages();                                // Création des pages de l’extension
    e1795854_TP1_default_settings();                            // Initialisation des variables par défaut
}


/**
 * Vérification de la version WP
 *
 * @param void
 * @return void
 */
function e1795854_TP1_check_version()
{
    global $wp_version;
    if(version_compare($wp_version, "4.9.8"))                   // Fonction PHP
        wp_die("Cette extension requiert WordPress version 4.9.8 ou plus.");
}


/**
 * Création de la table des annonces
 *
 * @param void
 * @return void
 */
function e1795854_TP1_create_table()
{
    global $wpdb;
    $sql = "CREATE TABLE $wpdb->prefix"."e1795854_TP1_ad (
        ID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
        make varchar(20) NOT NULL,
        model varchar(20) NOT NULL,
        colour varchar(20) NOT NULL,
        year smallint(4) UNSIGNED NOT NULL,
        kilometers mediumint(6) UNSIGNED NOT NULL,
        price mediumint UNSIGNED NOT NULL,
        visibility bool NOT NULL,
        creationDate date NOT NULL,
        IDUser bigint UNSIGNED NOT NULL,
        PRIMARY KEY (ID),
        FOREIGN KEY (IDUser) REFERENCES $wpdb->prefix"."users(ID)
    ) ".$wpdb->get_charset_collate();                           // Jeu de caractères utilisé pour l’encodage.
    require_once(ABSPATH . "wp-admin/includes/upgrade.php");    // Pour l’appel de la fonction dbDelta.
    dbDelta($sql);                                              // Création d’une nouvelle table ou modification de sa structure.
}


/**
 * Création des pages de l’extension
 *
 * @param void
 * @return void
 */
function e1795854_TP1_create_pages()
{
    $e1795854_TP1_page = array(
        "post_title"        => "e1795854 TP1",
        "post_status"       => "publish",
        "post_type"         => "page",
        "comment_status"    => "closed",
        "ping_status"       => "closed",
        "meta_input"        => array("e1795854_TP1" => "parent")
    );
    $parent = wp_insert_post($e1795854_TP1_page);

    $e1795854_TP1_page = array(
        "post_content"      => "[e1795854_TP1_insertion]",
        "post_title"        => "Ajout d’une annonce",
        "post_status"       => "publish",
        "post_type"         => "page",
        "comment_status"    => "closed",
        "ping_status"       => "closed",
        "post_parent"       => $parent,
        "meta_input"        => array("e1795854_TP1" => "insertion")
    );
    wp_insert_post($e1795854_TP1_page);

    $e1795854_TP1_page = array(
        "post_content"      => "[e1795854_TP1_list]",
        "post_title"        => "Liste des annonces",
        "post_status"       => "publish",
        "post_type"         => "page",
        "comment_status"    => "closed",
        "ping_status"       => "closed",
        "post_parent"       => $parent,
        "meta_input"        => array("e1795854_TP1" => "list")
    );
    wp_insert_post($e1795854_TP1_page);

    $e1795854_TP1_page = array(
        "post_content"      => "[e1795854_TP1_detail]",
        "post_title"        => "Détail de l’annonce",
        "post_status"       => "publish",
        "post_type"         => "page",
        "comment_status"    => "closed",
        "ping_status"       => "closed",
        "post_parent"       => $parent,
        "meta_input"        => array("e1795854_TP1" => "detail")
    );
    wp_insert_post($e1795854_TP1_page);

    $e1795854_TP1_page = array(
        "post_content"      => "[e1795854_TP1_modification]",
        "post_title"        => "Modification de l’annonce",
        "post_status"       => "publish",
        "post_type"         => "page",
        "comment_status"    => "closed",
        "ping_status"       => "closed",
        "post_parent"       => $parent,
        "meta_input"        => array("e1795854_TP1" => "modification")
    );
    wp_insert_post($e1795854_TP1_page);

    $e1795854_TP1_page = array(
        "post_content"      => "[e1795854_TP1_suppression]",
        "post_title"        => "Suppression de l’annonce",
        "post_status"       => "publish",
        "post_type"         => "page",
        "comment_status"    => "closed",
        "ping_status"       => "closed",
        "post_parent"       => $parent,
        "meta_input"        => array("e1795854_TP1" => "suppression")
    );
    wp_insert_post($e1795854_TP1_page);
}


/**
 * Inilialisation des valeurs d’option
 *
 * @param void
 * @return void
 */
function e1795854_TP1_default_settings()
{
    add_option(
        "e1795854_TP1_settings",
        array(
            "days"          => "0",
            "administrator" => "1",
            "editor"        => "1",
            "author"        => "1",
            "contributor"   => "1",
            "subscriber"    => "0",
            "visibility"    => "1"
        )
    );
}



?>
