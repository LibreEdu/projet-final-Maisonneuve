<?php

/** Ajout d’une annonce. */


add_shortcode("e1795854_TP1_insertion", "e1795854_TP1__insertion");


/**
 * Traitements pour l’ajout d’une annonce.
 *
 * @param void
 * @return string   Le résultat de la requête d’ajout suivi du formulaire.
 */
 function e1795854_TP1__insertion()
{
    if(e1795854_TP1_verif_settings())
    {
        ob_start();                        // Enclenche la temporisation de sortie (fonction PHP).
        e1795854_TP1_insert();             // Ajout d’une annonce.
        e1795854_TP1_form("insertion");    // Affichage du formulaire.
        return ob_get_clean();             // Lit le contenu courant du tampon de sortie puis l’efface (fonction PHP).
    }
    else {
?>
<p>Vous n’avez pas accès à cette page.</p>
<?php
    }
}


/**
 * Ajout d’une annonce dans la table des annonces.
 *
 * @param void
 * @return void
 */
function e1795854_TP1_insert()
{
    if(isset($_POST["make"], $_POST["model"], $_POST["colour"], $_POST["years"], $_POST["kilometers"], $_POST["price"], $_POST["visibility"]))
    {
        // Récupération et assainissement des valeurs du formulaire
        $make           = sanitize_text_field($_POST["make"]);
        $model          = sanitize_text_field($_POST["model"]);
        $colour         = sanitize_text_field($_POST["colour"]);
        $year           = sanitize_text_field($_POST["years"]);
        $kilometers     = sanitize_text_field($_POST["kilometers"]);
        $price          = sanitize_text_field($_POST["price"]);
        $visibility     = sanitize_text_field($_POST["visibility"]);
        $creationDate   = current_time("mysql");
        $IDUser         = get_current_user_id();

        // Insertion dans la table
        global $wpdb;
        $result = $wpdb->insert(
            $wpdb->prefix.'e1795854_TP1_ad',
            array(
                "make"          => $make,
                "model"         => $model,
                "colour"        => $colour,
                "year"          => $year,
                "kilometers"    => $kilometers,
                "price"         => $price,
                "visibility"    => $visibility,
                "creationDate"  => $creationDate,
                "IDUser"        => $IDUser
            ),
            array("%s","%s","%s","%d","%d","%d","%d","%s","%d"));

        // Feedback
        if($result):
?>
<p>L’annonce a été ajoutée.</p>
<?php
        else:
?>
<p>Échec lors de l’ajout de l’annonce.</p>
<?php
        endif;
    }
}

?>
