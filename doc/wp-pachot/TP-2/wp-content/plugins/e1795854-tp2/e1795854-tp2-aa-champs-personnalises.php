<?php

/** Typde de post personnalisé. */


/**
 * Crochet d’action
 *
 */
add_action('wp_insert_post', 'wpc_champs_personnalises_defaut');

/**
 * Traitement à l’installation du TPP
 *
 * @param integr $post_id l’identifiant du post
 * @return void
 */
function wpc_champs_personnalises_defaut($post_id)
 {
     if ( $_GET['post_type'] == 'e1795854_exhibition' ) {
         add_post_meta($post_id, 'date_debut', '', true);
         add_post_meta($post_id, 'date_fin', '', true);
     }
     return true;
 }
