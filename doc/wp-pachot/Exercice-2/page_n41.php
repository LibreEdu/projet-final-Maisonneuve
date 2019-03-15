<?php
/*
Template Name: N41 GestCar
*/

// Prise en compte de la sélection par marque ou par modèle
if(isset($_POST['marque']))
    $where = "WHERE marque = '" . sanitize_text_field($_POST["marque"]) . "'";
elseif(isset($_POST['modele']))
    $where = "WHERE modele = '" . sanitize_text_field($_POST["modele"]) . "'";
else
    $where = "";

// Requêtes SQL
$sqlAll = "SELECT * FROM $wpdb->prefix"."voiture " . $where . " ORDER BY annee";
$sqlMarque = "SELECT DISTINCT marque FROM $wpdb->prefix"."voiture ORDER BY marque";
$sqlModele = "SELECT DISTINCT modele FROM $wpdb->prefix"."voiture ORDER BY modele";

// Résultats des requêtes
$voitures = $wpdb->get_results($sqlAll);
$marques = $wpdb->get_results($sqlMarque);
$modeles = $wpdb->get_results($sqlModele);

// Utilisateur courant
$utilisateur = wp_get_current_user();

// Génération de la page
get_header();
?>
            <div class="wrap">
                <div id="primary" class="entry-content">
                    <main id="main" class="site-main" role="main">
                        <h1>Voitures par année croissantes</h1>
                        <h2>Sélection</h2>
                        <form action="<?php echo esc_url($_SERVER['REQUEST_URI']) ?>" method="post">
                            <label>Marque</label>
                             <select name="marque">
<?php

// Formulaire de sélection par marque
foreach ($marques as $ligne){
?>
                                <option value="<?= $ligne->marque ?>"><?= $ligne->marque ?></option>
<?php
}
?>
                            </select>
                            <input type="submit">
                        </form>
                        <form action="<?php echo esc_url($_SERVER['REQUEST_URI']) ?>" method="post">
                            <label>Modèle</label>
                             <select name="modele">
<?php

// Formulaire de sélection par modèle
foreach ($modeles as $ligne){
?>
                                <option value="<?= $ligne->modele ?>"><?= $ligne->modele ?></option>
<?php
}
?>
                            </select>
                            <input type="submit">
                        </form>
                        <h2>Résultat</h2>
                        <table>
                            <tr>
                                <th>Marque</th>
                                <th>Modèle</th>
                                <th>Couleur</th>
                                <th>Année</th>
                                <th>Kilométrage</th>
                                <th>Prix</th>
                            </tr>
<?php

// Parcours des resultats obtenus
foreach ($voitures as $voiture){
?>
                            <tr>
                                <td><?= $voiture->marque ?></td>
                                <td><?= $voiture->modele ?></td>
                                <td><?= $voiture->couleur ?></td>
                                <td><?= $voiture->annee ?></td>
                                <td><?= $voiture->kilometrage ?></td>
                                <td><?= $voiture->prix ?></td>
                            </tr>
<?php
}?>
                        </table>
<?php

// Affichage du lien
if($utilisateur->has_cap('administrator')):
?>
                        <p><a href="<?php echo get_site_url();?>/saisie/">Saisie d’une nouvelle voiture</a></p>
<?php
endif;
?>
                    </main><!-- #main -->
                </div><!-- #primary -->
            </div><!-- .wrap --><?php
get_footer();
