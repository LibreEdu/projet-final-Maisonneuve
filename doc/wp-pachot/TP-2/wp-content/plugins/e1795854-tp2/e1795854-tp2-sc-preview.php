<?php

/** Formulaire. */


add_shortcode("e1795854_tp2_preview", "e1795854_tp2__form");


/**
 * Traitements pour l’ajout d’une annonce.
 *
 * @param void
 * @return string   Le résultat de la requête d’ajout suivi du formulaire.
 */
 function e1795854_tp2__form()
{
    ob_start();                        // Enclenche la temporisation de sortie (fonction PHP).
    e1795854_tp2_insert();             // Ajout des données.
    e1795854_tp2_form();               // Affichage du formulaire.
    return ob_get_clean();             // Lit le contenu courant du tampon de sortie puis l’efface (fonction PHP).
}


/**
 * Ajout d’une annonce dans la table des annonces.
 *
 * @param void
 * @return void
 */
function e1795854_tp2_insert()
{
    if(isset($_POST["post_id"], $_POST["first_name"], $_POST["last_name"], $_POST["email"]))
    {
        // Récupération et assainissement des valeurs du formulaire
        $post_id    = sanitize_text_field($_POST["post_id"]);
        $first_name = sanitize_text_field($_POST["first_name"]);
        $last_name  = sanitize_text_field($_POST["last_name"]);
        $email      = sanitize_text_field($_POST["email"]);

        // Insertion dans la table
        global $wpdb;
        $result = $wpdb->insert(
            $wpdb->prefix.'vernissage',
            array(
                "post_id"       => $post_id,
                "first_name"    => $first_name,
                "last_name"     => $last_name,
                "email"         => $email
            ),
            array("%d","%s","%s","%s"));

        // Feedback
        if($result):
?>
            <p class="msg">Inscription enregistrée.</p>
<?php
        else:
?>
            <p class="msg">Échec lors de l’inscription.</p>
<?php
        endif;
    }
}


/**
 * Formulaire
 *
 * @param void
 * @return void
*/
function e1795854_tp2_form()
{
?>

        <form method="post">
            <fieldset>
                <legend>S’inscrire au vernissage</legend>
                <input type="hidden" name="post_id" value="<?php the_ID(); ?>">
                <label>Prénom *</label>
                <input type="text" name="first_name" maxlength="50" required/>
                <br />
                <label>Nom *</label>
                <input type="text" name="last_name" maxlength="50" required/>
                <br />
                <label>Courriel *</label>
                <input type="text" name="email" maxlength="100" required/>
                <br />
                <input type="submit" value="S’inscrire">
                <br><span>(*) Valeur requise.</span>
            </fieldset>
        </form>
<?php
}
