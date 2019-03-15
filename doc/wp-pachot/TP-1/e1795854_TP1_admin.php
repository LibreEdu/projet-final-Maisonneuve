<?php

/** Menu d’administration. */


// L’exécution du hook 'admin_menu' sert à compléter le panneau d’administration, pour les extensions et les thèmes
add_action("admin_menu", "e1795854_TP1_admin");


/**
 * Ajout du formulaire des réglages du panneau d’administration, et ajout d’une action d’initialisation du traitement de cette page au hook 'admin_init'
 *
 * @param void
 * @return void
 */
function e1795854_TP1_admin() {
    add_menu_page(
        "e1795854 TP1",                         // Balise title de la page des réglages
        "e1795854 TP1",                         // Texte de menu de la page des réglages dans le menu latéral gauche
        "administrator",                        // Capacité pour afficher cette page
        "e1795854-TP1-settings",                // Slug dans l’url de la page
        "e1795854_TP1__settings");              // Fonction d’affichage de la page

    // Initialisation du formulaire des réglages, avant son affichage.
    add_action("admin_init", "e1795854_TP1_settings_init" );
}


/**
 * Initialisation du formulaire des réglages
 *
 * @param void
 * @return void
 */
function e1795854_TP1_settings_init() {
    register_setting(
            "e1795854_TP1_settings_group",      // Nom de la zone des réglages, associée à la saisie des valeurs de l’option
            "e1795854_TP1_settings",            // Nom de l’option des réglages
            "e1795854_TP1_settings_sanitize");  // Fonction pour assainir les options des réglages
}


/**
 * Assainissement des valeurs renvoyées par le formulaire des réglages
 *
 * @param void
 * @return void
 */
function e1795854_TP1_settings_sanitize( $input ) {
    $input["days"]          = sanitize_text_field($input["days"]);
    $input["editor"]        = sanitize_text_field($input["editor"]);
    $input["author"]        = sanitize_text_field($input["author"]);
    $input["contributor"]   = sanitize_text_field($input["contributor"]);
    $input["visibility"]    = sanitize_text_field($input["visibility"]);
    $input["administrator"] = "1";
    $input["subscriber"]    = "0";
    return $input;
}


/**
 * Formulaire des réglages
 *
 * @param void
 * @return void
 */
function e1795854_TP1__settings() {
    // action="options.php" <= https://codex.wordpress.org/Creating_Options_Pages#Form_Tag

    // Récupération des options
    $settings = get_option("e1795854_TP1_settings");

    // Initialisation des variables du formulaire
    $days           = $settings["days"] ?? "";
    $editor         = $settings["editor"] ?? "";
    $author         = $settings["author"] ?? "";
    $contributor    = $settings["contributor"] ?? "";
    $visibility     = $settings["visibility"] ?? "";

?>
<div class="wrap">
    <h2>Réglages de l’extension e1795854 TP1</h2>
    <form method="post" action="options.php">
        <?php settings_fields("e1795854_TP1_settings_group");   // Génération de balises input cachées pour faire le lien avec la fonction register_setting par le paramètre option_group ?>

        <h3>Temps d’affichage de l’annonce</h3>
        <p>Nombre de jours, « 0 » (zéro) pour une durée illimitée : <input type="number" name="e1795854_TP1_settings[days]" min="0" value="<?= $days; ?>" required /></p>
        <h3>Ajouter une annonce, la modifier et la supprimer</h3>
        <table class="form-table">
            <tr>
                <th scope="row">Éditeur</th>
                <td>
                    <label for="editor1"><input type="radio" name="e1795854_TP1_settings[editor]" id="editor1" value="1" <?php checked($editor, "1"); ?>/> Oui</label>
                    <br />
                    <label for="editor0"><input type="radio" name="e1795854_TP1_settings[editor]" id="editor0" value="0" <?php checked($editor, "0"); ?>/> Non</label>
                </td>
            </tr>
            <tr>
                <th scope="row">Auteur</th>
                <td>
                    <label for="author1"><input type="radio" name="e1795854_TP1_settings[author]" id="author1" value="1" <?php checked($author, "1"); ?>/> Oui</label>
                    <br />
                    <label for="author0"><input type="radio" name="e1795854_TP1_settings[author]" id="author0" value="0" <?php checked($author, "0"); ?>/> Non</label>
                </td>
            </tr>
            <tr>
                <th scope="row">Contributeur</th>
                <td>
                    <label for="contributor1"><input type="radio" name="e1795854_TP1_settings[contributor]" id="contributor1" value="1" <?php checked($contributor, "1"); ?> /> Oui</label>
                    <br />
                    <label for="contributor0"><input type="radio" name="e1795854_TP1_settings[contributor]" id="contributor0" value="0" <?php checked($contributor, "0"); ?> /> Non</label>
                </td>
            </tr>
        </table>
        <h3>Formulaire d’ajout</h3>
        <p>Par défaut, l’annonce doit-elle être « Visible » ou « Invisible » ?
            &nbsp;
            <label for="visible">
                <input type="radio" name="e1795854_TP1_settings[visibility]" id="visible" value="1" <?php checked($visibility, "1"); ?>/>
                Visible
            </label>
            &nbsp;
            <label for="invisible">
                <input type="radio" name="e1795854_TP1_settings[visibility]" id="invisible" value="0" <?php checked($visibility, "0"); ?>/>
                Invisible
            </label>
        </p>
        <p class="submit">
            <input type="submit" class="button-primary" value="Enregistrer les modifications" />
        </p>
    </form>
</div>
<?php
 }
?>
