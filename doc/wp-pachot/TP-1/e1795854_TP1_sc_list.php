<?php

/** Liste des annonces. */
add_shortcode("e1795854_TP1_list", "e1795854_TP1__list");


/**
 * Traitements pour la liste des annonces
 *
 * @param void
 * @return string   Filtre de recherche et résultat de la recherche
 */
 function e1795854_TP1__list()
 {
    ob_start();               // Enclenche la temporisation de sortie (fonction PHP).
    e1795854_TP1_list_view(); // Filtre et affichage de la liste des voitures.
    return ob_get_clean();    // Lit le contenu courant du tampon de sortie puis l’efface (fonction PHP).
}


/**
 * Filtre et affichage de la liste des voitures.
 *
 * @param void
 * @return void
 */
function e1795854_TP1_list_view()
{
    // Récupération du tableau des options
    $settings       = get_option("e1795854_TP1_settings");

    // Initialisation des variables du formulaire
    $make           = sanitize_text_field($_POST["make"] ?? "");
    $model          = sanitize_text_field($_POST["model"] ?? "");
    $colour         = sanitize_text_field($_POST["colour"] ?? "");
    $year           = sanitize_text_field($_POST["years"] ?? "");
    $kilometers     = sanitize_text_field($_POST["kilometers"] ?? "");
    $price          = sanitize_text_field($_POST["price"] ?? "");
    $sort           = sanitize_text_field($_POST["sort"] ?? "price");
    $order          = sanitize_text_field($_POST["order"] ?? "ASC");

    // Paramètres pour la requête SQL selon le contexte
    if(wp_get_current_user()->roles[0]) { // L’utilisateur est identifié
        $visibility = current_user_can('administrator') ? ""  : "AND IDUser = " . wp_get_current_user()->ID;
        $days       = "";
    }
    else { // L’utilisateur n’est pas identifié
        $visibility = "AND visibility = true";
        $days       = $settings["days"] ?? "";
        $days       = $days ? "AND DATEDIFF(CURDATE(), creationDate) <= " . $days : "";
    }

    // S’il n’y a pas de prix maximum fixé par l’utilisateur alors on le fixe à 999999
    $priceSQL = $price ? $price : "999999";

    global $wpdb;
    $sql  = "SELECT * FROM $wpdb->prefix"."e1795854_TP1_ad
        WHERE make LIKE '%s' AND model LIKE '%s' AND colour LIKE '%s' AND price <= '%d' $visibility $days
        ORDER BY $sort $order";

    $ads = $wpdb->get_results($wpdb->prepare($sql, '%'.$make.'%', '%'.$model.'%', '%'.$colour.'%', $priceSQL));

    // Droits de l'utilisateur à voir, modifier et supprimer
    $e1795854_TP1_verif_settings = e1795854_TP1_verif_settings();

    // Si l’utilisateur a les droits en lecture, en modification et en suppression
    if($e1795854_TP1_verif_settings):
        $page_add_car = get_page_by_title("Ajout d’une annonce");
?>
<p><a href="<?php echo get_permalink($page_add_car)?>">Ajout d’une annonce</a></p>
<?php
    endif;
?>

        <form method="post">
            <label>Critères de recherche</label>
            <br />
            <input type="text" name="make" value="<?= $make; ?>" placeholder="Marques contenant cette chaine de cararactères" />
            <br />
            <input type="text" name="model" value="<?= $model; ?>" placeholder="Modèles contenant cette chaine de cararactères" />
            <br />
            <input type="text" name="colour" value="<?= $colour; ?>" placeholder="Couleurs contenant cette chaine de cararactères" />
            <br />
            <input type="text" name="price" value="<?= $price; ?>" placeholder="Prix maximum" />
            <br />
            <label>Annonces triées selon &nbsp;
                <select name="sort">
<?php
    // Si l’utilisateur est connecté
    if(wp_get_current_user()->roles[0]) :
?>
                    <option value="ID" <?php selected($sort, "ID"); ?>>l’identifiant de l’annonce</option>
<?php
    endif;
?>
                    <option value="make" <?php selected($sort, "order"); ?>>la marque</option>
                    <option value="model" <?php selected($sort, "model"); ?>>le modèle</option>
                    <option value="colour" <?php selected($sort, "colour"); ?>>la couleur</option>
                    <option value="year" <?php selected($sort, "year"); ?>>l’année</option>
                    <option value="kilometers" <?php selected($sort, "kilometers"); ?>>le kilométrage</option>
                    <option value="price" <?php selected($sort, "price"); ?>>le prix</option>
<?php
    // Si l’utilisateur est connecté
    if(wp_get_current_user()->roles[0]) :
?>
                    <option value="visibility" <?php selected($sort, "visibility"); ?>>la visibilité</option>
                    <option value="creationDate" <?php selected($sort, "creationDate"); ?>>la date de création</option>
<?php
    endif;

    // Si l’utilisateur est l’administrateur
    if(current_user_can('administrator')) :
?>
                    <option value="IDUser" <?php selected($sort, "IDUser"); ?>>l’identifiant de l’utilisateur</option>
<?php
    endif;
?>
                </select>
            </label>
            <label for="ascending">
                <input type="radio" name="order" id="ascending" value="ASC" <?php checked($order, "ASC"); ?> />
                en ordre croissant
            </label>
            <label for="descending">
                <input type="radio" name="order" id="descending" value="DESC" <?php checked($order, "DESC"); ?> />
                en ordre décroissant</label>
            <br />
            <input type="submit" value="Rechercher">
        </form>
        <br />
<?php
    if (count($ads)) : // Il y a une annonce au moins

        // Récupération des métadonnées
        $detail         = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'e1795854_TP1' AND meta_value = 'detail'");
        $modification   = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'e1795854_TP1' AND meta_value = 'modification'");
        $suppression    = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'e1795854_TP1' AND meta_value = 'suppression'");

        // Récupération du lien des pages
        $detail_permalink       = get_permalink($detail->post_id);
        $modification_permalink = get_permalink($modification->post_id);
        $suppression_permalink  = get_permalink($suppression->post_id);

?>
        <table>
<?php
        foreach ($ads as $ad) :
?>
            <tr>
<?php
            // Si l’utilisateur est connecté
            if(wp_get_current_user()->roles[0]) :
                $ID   = '<span title="L’identifiant de l’annonce">' . $ad->ID . '</span>';
?>
                <td><?= $ID ?></td>
<?php
            endif;
?>
                <td><?= $ad->make ?></td>
                <td><?= $ad->model ?></td>
                <td><?= $ad->colour ?></td>
                <td><?= $ad->year ?></td>
                <td><?php echo number_format($ad->kilometers, 0, '.', ' ') ?> km</td>
                <td><?php echo number_format($ad->price, 0, '.', ' ') ?> $</td>
<?php
            // Si l’utilisateur est connecté
            if(wp_get_current_user()->roles[0]) :
                $visibility     = $ad->visibility ? '<span title="Visible">V</span>' : '<span title="Invisible">I</span>';
                $creationDate   = $ad->creationDate;
                $IDUser         = '<span title="L’identifiant de l’utilisateur">' . $ad->IDUser . '</span>';

                // identifiant de la voiture
                $car = "?ID=" . $ad->ID;

                // Génération des liens de détail, de modification et de suppression
                $D = '<a href="' . $detail_permalink       . $car . '" title="Détail">D</a>';
                $M = '<a href="' . $modification_permalink . $car . '" title="Modification">M</a>';
                $S = '<a href="' . $suppression_permalink  . $car . '" title="Suppression">S</a>';
?>
                <td><?= $visibility ?></td>
                <td><?= $creationDate ?></td>
                <td><?= $IDUser ?></td>
<?php
                // Si l’utilisateur a les droits en lecture, en modification et en suppression
                if($e1795854_TP1_verif_settings) :
?>
                <td><?= $D ?></td>
                <td><?= $M ?></td>
                <td><?= $S ?></td>
<?php
                endif;
            endif;
?>
            </tr>
<?php
        endforeach;
?>
        </table><?php
    else : // Il n’y a pas d’annonces
?>
        <p>Aucune annonce trouvée.</p>
<?php
    endif;
}

?>
