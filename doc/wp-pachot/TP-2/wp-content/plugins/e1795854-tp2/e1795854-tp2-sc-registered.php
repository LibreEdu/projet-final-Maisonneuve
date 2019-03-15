<?php

/** Liste des annonces. */
add_shortcode("e1795854_tp2_registered", "e1795854_tp2__registered");


/**
 * Traitements pour la liste des annonces
 *
 * @param void
 * @return string   Filtre de recherche et résultat de la recherche
 */
 function e1795854_tp2__registered()
 {
    ob_start();               // Enclenche la temporisation de sortie (fonction PHP).
    e1795854_tp2_registered(); // Filtre et affichage de la liste des voitures.
    return ob_get_clean();    // Lit le contenu courant du tampon de sortie puis l’efface (fonction PHP).
}


/**
 * Filtre et affichage de la liste des voitures.
 *
 * @param void
 * @return void
 */
function e1795854_tp2_registered()
{
    // Paramètres pour la requête SQL selon le contexte
    if( wp_get_current_user()->roles[0] ) : // L’utilisateur est identifié

        // Vérification des rôles
        if( wp_get_current_user()->roles[0] != "subscriber"):

            // On récupère l'identifiant du TPP
            $post_id = get_the_ID();

            // Connection à la base de données
            global $wpdb;

            // Récupération des inscrits à une exposition
            $sql  = "SELECT * FROM $wpdb->prefix"."vernissage
                WHERE post_id = %d";

            $inscrits = $wpdb->get_results($wpdb->prepare($sql, $post_id));
            if (count($inscrits)) :
                $i = 0;
?>

            <p><strong>Personnes inscrites (<?php echo count($inscrits);?>) :</strong></p>
        <table>
<?php
                            foreach ($inscrits as $inscrit) :
                                $i++;
?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $inscrit->first_name ?></td>
                <td><?= $inscrit->last_name ?></td>
                <td><?= $inscrit->email ?></td>
            </tr>
<?php
                            endforeach;
?>
        </table>
<?php
            else:
?>
                    <p><strong>Aucun inscrit</strong></p>
<?php
            endif;
        endif;
    endif;
}
