<?php

/** Suppression de l’annonce. */


add_shortcode("e1795854_TP1_suppression", "e1795854_TP1__suppression");


/**
 * Traitements pour la suppression.
 *
 * @param void
 * @return string 	La page de suppression
 */
function e1795854_TP1__suppression()
{
    if(e1795854_TP1_verif_settings())
    {
        ob_start();            					// Enclenche la temporisation de sortie (fonction PHP).
        e1795854_TP1_delete();             		// Suppression de l’annonce.
        e1795854_TP1_verif_form("suppression");	// Affichage du formulaire.
        return ob_get_clean(); 					// Lit le contenu courant du tampon de sortie puis l’efface (fonction PHP).
    }
    else {
?>
<p>Vous n’avez pas accès à cette page.</p>
<?php
    }
}


/**
 * Suppression de l’annonce.
 *
 * @param void
 * @return void
 */
function e1795854_TP1_delete()
{
    if(isset($_POST["ID"]))
    {
        // Récupération et assainissement des valeurs du formulaire
        $ID           	= sanitize_text_field($_POST["ID"]);



        // Insertion dans la table
        global $wpdb;

        $result = $wpdb->delete(
            $wpdb->prefix.'e1795854_TP1_ad',
            array(
                "ID"          	=> $ID
            ),
            array("%d")
        );

        // Feedback
        if($result):
?>
<p>L’annonce a été supprimée.</p>
<?php
        else:
?>
<p>Échec lors de la suppression de l’annonce.</p>
<?php
        endif;
    }
}

?>
