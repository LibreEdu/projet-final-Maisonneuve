<?php

/** Fichier des traductions. */


add_action( 'plugins_loaded', 'e1795854_TP2_load_textdomain' );


/**
 * Charge les traductions de l'extension
 *
 */
function e1795854_TP2_load_textdomain() {
    load_plugin_textdomain( 'e1795854-tp2', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
