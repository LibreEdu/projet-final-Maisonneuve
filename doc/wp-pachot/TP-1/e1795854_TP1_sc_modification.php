<?php

/** Modification de l’annonce. */


add_shortcode("e1795854_TP1_modification", "e1795854_TP1__modification");


/**
 * Traitements pour la modification.
 *
 * @param void
 * @return string 	La page de modification
 */
function e1795854_TP1__modification()
{
    if(e1795854_TP1_verif_settings())
    {
        ob_start();            						// Enclenche la temporisation de sortie (fonction PHP).
        e1795854_TP1_update();             			// Ajout de l’annonce.
        e1795854_TP1_verif_form("modification");	// Affichage du formulaire.
        return ob_get_clean(); 						// Lit le contenu courant du tampon de sortie puis l’efface (fonction PHP).
    }
    else {
?>
<p>Vous n’avez pas accès à cette page.</p>
<?php
    }
}


/**
 * Mise-à-jour de l’annonce.
 *
 * @param void
 * @return void
 */
function e1795854_TP1_update()
{
    if(isset($_POST["ID"], $_POST["make"], $_POST["model"], $_POST["colour"], $_POST["years"], $_POST["kilometers"], $_POST["price"], $_POST["visibility"]))
    {
        // Récupération et assainissement des valeurs du formulaire
        $ID           	= sanitize_text_field($_POST["ID"]);
        $make           = sanitize_text_field($_POST["make"]);
        $model          = sanitize_text_field($_POST["model"]);
        $colour         = sanitize_text_field($_POST["colour"]);
        $year           = sanitize_text_field($_POST["years"]);
        $kilometers     = sanitize_text_field($_POST["kilometers"]);
        $price          = sanitize_text_field($_POST["price"]);
        $visibility     = sanitize_text_field($_POST["visibility"]);


        // Insertion dans la table
        global $wpdb;

        $result = $wpdb->update(
            $wpdb->prefix.'e1795854_TP1_ad',
            array(
                "make"          => $make,
                "model"         => $model,
                "colour"        => $colour,
                "year"          => $year,
                "kilometers"    => $kilometers,
                "price"         => $price,
                "visibility"    => $visibility
            ),
            array(
                "ID"          	=> $ID
            ),
            array("%s","%s","%s","%d","%d","%d","%d"),
            array("%d")
        );

        // Feedback
        if($result):
?>
<p>L’annonce a été modifiée.</p>
<?php
        else:
?>
<p>Échec lors de la modification de l’annonce.</p>
<?php
        endif;
    }
}

?>
