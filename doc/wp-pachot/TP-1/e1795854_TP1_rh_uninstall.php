<?php

/** Désinstallation de l’extension. */


/**
 * Traitement à la désinstallation de l’extension
 *
 * @param void
 * @return void
 */
function e1795854_TP1_uninstall()
{
    e1795854_TP1_drop_table();
    e1795854_TP1_delete_settings();
}


/**
 * Suppression de la table
 *
 * @param void
 * @return void
 */
function e1795854_TP1_drop_table()
{
    global $wpdb;
    $sql = "DROP TABLE $wpdb->prefix"."e1795854_TP1_ad";
    $wpdb->query($sql);
}


/**
 * Suppression des valeurs d’option
 *
 * @param void
 * @return void
 */
function e1795854_TP1_delete_settings() {
    delete_option("e1795854_TP1_settings");
}

?>
