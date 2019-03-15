<?php

/** Désactivation de l’extension. */


/**
 * Traitement à la désactivation de l’extension
 *
 * @param void
 * @return void
 */
function e1795854_TP1_deactivation()
{
    e1795854_TP1_delete_pages();
}


/**
 * Suppression des pages de l’extension
 *
 * @param void
 * @return void
 */
function e1795854_TP1_delete_pages()
{
    global $wpdb;
    $postmetas = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'e1795854_TP1'");
    $force_delete = true;
    foreach ($postmetas as $postmeta)
    {
        wp_delete_post($postmeta->post_id, $force_delete);
    }
}

?>
