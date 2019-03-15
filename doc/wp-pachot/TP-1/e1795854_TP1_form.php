<?php

/** Formulaire */


/**
 * Vérifie si l’utilisateur courant a les droits pour voir le détail, modifier et supprimer, soit d’une manière génrale, soit pour une annonce précise
 *
 * @param integer   $ID     Identifant de l’annonce
 * @return boolean
*/
function e1795854_TP1_verif_settings($ID=0)
{
    // Récupération des options
    $settings = get_option("e1795854_TP1_settings");

    // Rôle de l’utilisateur courant
    $role = wp_get_current_user()->roles[0];

    return $ID ? $role == "administrator" || $settings[$role] && wp_get_current_user()->ID == $ID : $settings[$role];
}


/**
 * Vérifie si l’utilisateur courant a les droits d’afficher le formulaire pour une annonce précise
 *
 * @param string $action    Action a exécuter
 * @return void
 */
function e1795854_TP1_verif_form(string $action)
{
    $ID = sanitize_text_field($_GET["ID"] ?? "");

    global $wpdb;
    $sql = "SELECT * FROM $wpdb->prefix"."e1795854_TP1_ad WHERE ID =%d";
    $car = $wpdb->get_row($wpdb->prepare($sql, $ID));

    if (e1795854_TP1_verif_settings($car->IDUser))
        e1795854_TP1_form($action, $car);
    else
        echo "<p>Désolé, vous n’avez pas accès à cette page.</p>";
}


/**
 * Formulaire pour l’ajout, la modification et la suppression
 *
 * @param string $action    Action exécutée
 * @param array $car        Données de l’annonce
 * @return void
*/
// https://codex.wordpress.org/Reserved_Terms
function e1795854_TP1_form(string $action, $car=null)
{
    $ID         = $car->ID ?? "";
    $make       = $car->make ?? "";
    $model      = $car->model ?? "";
    $colour     = $car->colour ?? "";
    $years      = $car->year ?? "";
    $kilometers = $car->kilometers ?? "";
    $price      = $car->price ?? "";
    $visibility = $car->visibility ?? "";

    switch ($action){
        case "insertion":
            // Récupération des options
            $settings   = get_option("e1795854_TP1_settings");

            // Initialisation de la visibilité
            $visibility = $settings["visibility"] ?? "";
        case "modification":
            $disabled   = "";
            break;
        case "detail":
        case "suppression":
            // Désactivation des champs du formulaire
            $disabled   = "disabled";
            break;
    }
?>

        <form method="post">
            <input type="hidden" name="ID" value="<?= $ID ?>">
            <label>Marque *</label>
            <input type="text" name="make" value="<?= $make ?>" maxlength="20" required <?= $disabled ?>/>
            <br />
            <label>Modèle *</label>
            <input type="text" name="model" value="<?= $model ?>" maxlength="20" required <?= $disabled ?>/>
            <br />
            <label>Couleur *</label>
            <input type="text" name="colour" value="<?= $colour ?>" maxlength="20" required <?= $disabled ?>/>
            <br />
            <label>Année *</label>
            <input type="number" name="years" value="<?= $years ?>" min="1950" max="<?php echo date('Y') ?>" required <?= $disabled ?>/>
            <br />
            <label>Kilométrage *</label>
            <input type="number" name="kilometers" value="<?= $kilometers ?>" min="0" max="999999" required <?= $disabled ?>/>
            <br />
            <label>Prix *</label>
            <input type="number" name="price" min="0" value="<?= $price ?>" max="16000000" required <?= $disabled ?>/>
            <br />
            <label for="visible">
                <input type="radio" name="visibility" id="visible" value="1"<?php checked($visibility, "1"); ?> <?= $disabled ?>/>
                Visible
            </label>
            <label for="invisible">
                <input type="radio" name="visibility" id="invisible" value="0"<?php checked($visibility, "0"); ?> <?= $disabled ?>/>
                Invisible
            </label>
            <br />
<?php
    switch ($action):
        case "insertion":
?>
            <input type="submit" value="Ajoutez l’annonce">
<?php
            break;
        case "modification":
?>
            <input type="submit" value="Modifiez l’annonce">
<?php
            break;
        case "suppression":
?>
            <input type="submit" value="Confirmez la suppression de l’annonce">
<?php
    endswitch ?>
        </form>
        <br />
        <p>(*) Valeur requise.</p>
<?php
}
?>
