<?php
/*
Plugin Name: N41 GestCar
Plugin URI: https://fr.wordpress.org/plugins/n41-gestcar/
Description: Gestion de la vente de voitures d’occasion.
Version: 1.0
Author: Alexandre Pachot
Author URI: https://e1795854.webdev.cmaisonneuve.qc.ca/
*/




// Hook d’activation
register_activation_hook( __FILE__, 'n41_activation' );


/**
 * Traitement à l’activation de l’extension.
 *
 * @param void
 * @return void
 */
function n41_activation(){
    n41_creation();
}


/**
 * Création de la table voiture
 *
 * @param void
 * @return void
 */
function n41_creation(){
    global $wpdb;
    $sql = "CREATE TABLE $wpdb->prefix"."voiture (
        voitureId bigint UNSIGNED NOT NULL AUTO_INCREMENT,
        marque varchar(20) NOT NULL,
        modele varchar(20) NOT NULL,
        couleur varchar(20) NOT NULL,
        annee smallint(4) UNSIGNED NOT NULL,
        kilometrage mediumint(6) UNSIGNED NOT NULL,
        prix mediumint UNSIGNED NOT NULL,
        PRIMARY KEY (VoitureId)
    ) ".$wpdb->get_charset_collate();                           // Jeu de caractères utilisé pour l’encodage.
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');    // Pour l’appel de la fonction dbDelta.
    dbDelta($sql);                                              // Création d’une nouvelle table ou modification de sa structure.
}



// Shortcode
add_shortcode('n41_formulaire', 'n41_ajout_formulaire');


/**
 * Ajout d’une voiture dans la table voiture et formulaire de saisie d’une voiture.
 *
 * @param void
 * @return string Le résultat de la requête d’ajout suivi du formulaire.
 */
 function n41_ajout_formulaire(){
     ob_start();            // Enclenche la temporisation de sortie (fonction PHP)
     n41_ajout();
     n41_formulaire();
     return ob_get_clean(); // Lit le contenu courant du tampon de sortie puis l'efface (fonction PHP)
}


/**
 * Ajout d’une voiture dans la table voiture.
 *
 * @param void
 * @return void
 */
function n41_ajout(){
    if(isset($_POST['saisieVoiture'])){
        // Assainissement des valeurs du formulaire
        $marque         = sanitize_text_field($_POST["marque"]);
        $modele         = sanitize_text_field($_POST["modele"]);
        $couleur        = sanitize_text_field($_POST["couleur"]);
        $annee          = sanitize_text_field($_POST["annee"]);
        $kilometrage    = sanitize_text_field($_POST["kilometrage"]);
        $prix           = sanitize_text_field($_POST["prix"]);

        // insertion dans la table
        global $wpdb;
        $wpdb->insert(
            $wpdb->prefix.'voiture',
            array(
                'marque'        => $marque,
                'modele'        => $modele,
                'couleur'       => $couleur,
                'annee'         => $annee,
                'kilometrage'   => $kilometrage,
                'prix'          => $prix),
            array('%s','%s','%s','%d','%d','%d'));
?>
<p>La voiture a été ajoutée.</p>
<?php
    }
}


/**
 * Formulaire de saisie
 *
 * @param void
 * @return void
*/
function n41_formulaire(){
    $utilisateur = wp_get_current_user();
    if($utilisateur->has_cap('administrator')):
?>
        <form action="<?php echo esc_url($_SERVER['REQUEST_URI']) ?>" method="post">
            <label>Marque</label>
            <input type="text" name="marque" maxlength="20" pattern="[ a-zàâéèêëîïôùûüÿçæœA-ZÀÂÉÈÊËÎÏÔÙŸÇÆŒ'’-]+" title="Des lettres de l’alphabet français." required>
            <label>Modèle</label>
            <input type="text" name="modele" maxlength="20" pattern="[ 0-9a-zàâéèêëîïôùûüÿçæœA-ZÀÂÉÈÊËÎÏÔÙŸÇÆŒ'’-]+" title="Une chaine alphanumérique." required>
            <label>Couleur</label>
            <input type="text" name="couleur" maxlength="20" pattern="[ a-zàâéèêëîïôùûüÿçæœA-ZÀÂÉÈÊËÎÏÔÙŸÇÆŒ'’-]+" title="Des lettres de l’alphabet français." required>
            <label>Année</label>
            <input type="number" name="annee" min="1950" max="2018" required>
            <label>Kilométrage</label>
            <input type="number" name="kilometrage" min="0" max="999999" required>
            <label>Prix</label>
            <input type="number" name="prix" min="0" max="16000000" required>
            <br>
            <input type="submit" name="saisieVoiture" value="Envoyez">
        </form><?php
    endif;
}




// Hook de désinstallation
register_uninstall_hook(__FILE__, 'n41_suppression');


/**
 * Traitement à la désinstallation de l’extension
 *
 * @param void
 * @return void
 */
function n41_suppression(){
    n41_drop();
}


/**
 * Suppression de la table
 *
 * @param void
 * @return void
 */
function n41_drop(){
    global $wpdb;
    $sql = "DROP TABLE $wpdb->prefix"."voiture";
    $wpdb->query($sql);
}




?>
