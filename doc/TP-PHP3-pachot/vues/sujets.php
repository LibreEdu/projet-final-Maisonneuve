        <div class="row bg-light">
            <div class="col">
                <p></p>
            </div>
        </div>
        <div class="row text-center bg-light">
            <div class="col">
                <h2>Liste des sujets</h2>
            </div>
        </div>
<?php
    // Récupération des données
    $posts = $data["sujets"];

    // Tableau qui pour chaque sujet va contenir le nombre de réponses qu’il a.
    $nbReponsesParSujet = array();

    // Compte le nombre de réponses par sujet
    foreach($posts as $post) {
        // Si c’est un sujet
        if ($post->idSujet === NULL)
            // alors initialisation du nombre de réponse
            $nbReponsesParSujet[$post->id] = 0;
        else
            // sinon incrémentation du nombre de réponses
            $nbReponsesParSujet[$post->idSujet] = $nbReponsesParSujet[$post->idSujet] + 1;
    }

    // Tableau pour savoir si un sujet a déjà été affiché
    $sujetsAffiches = array();

    // Entête du tableau
?>
        <div class="row bg-light font-weight-bold">
            <div class="col-lg-9 text-left">
                Sujet
            </div>
            <div class="col-lg-1 text-center">
                Usager
            </div>
            <div class="col-lg-1 text-center">
                Réponses
            </div>
            <div class="col-lg-1 text-center">
            </div>
        </div>
<?php
    // On parcourt le tableau des post à partir du dernier post
    for ($i=count($posts)-1; $i >=0 ; $i--) { 
?>
<?php
        // Si le post est un sujet
        if ($posts[$i]->idSujet === NULL) {
            // Si le sujet n’a pas déjà été affiché (c.-à-d il a 0 réponse)
            if (!in_array($posts[$i]->id, $sujetsAffiches)) {
?>
        <div class="row bg-light">
            <div class="col-lg-9 text-left">
<?php           // Titre
                echo "\t\t\t\t<a href='index.php?Posts&action=sujet&id={$posts[$i]->id}'>" . htmlspecialchars($posts[$i]->titre) . "</a>\n";
?>
            </div>
            <div class="col-lg-1 text-center">
<?php           // Usager
                echo "\t\t\t\t{$posts[$i]->nomUsager}\n";
?>
            </div>
            <div class="col-lg-1 text-center">
<?php           // Réponses
                echo "\t\t\t\t{$nbReponsesParSujet[$posts[$i]->id]}\n";
?>
            </div>
<?php
                if (($_SESSION["administrateur"])){
?>
            <div class="col-lg-1 text-center">
<?php           // Réponses
                echo "\t\t\t\t<a href='index.php?Posts&action=supprimer&id={$posts[$i]->id}'>Supprimer</a>\n";
?>
            </div>
<?php
                }
?>
        </div>
<?php
            }
        }
        // Si le post n’est pas un sujet alors c’est une réponse
        else 
            // Si le sujet n’a pas déjà été affiché (c.-à-d, c’est la dernière réponse)
            if (!in_array($posts[$i]->idSujet, $sujetsAffiches)) {
                // On note que le sujet va être affiché
                $sujetsAffiches[] =  $posts[$i]->idSujet;
?>
        <div class="row bg-light">
            <div class="col-lg-9 text-left">
<?php           // Titre
                echo "\t\t\t\t<a href='index.php?Posts&action=sujet&id={$posts[$i]->idSujet}'>" . htmlspecialchars($posts[$posts[$i]->idSujet - 1]->titre) . "</a>\n";
?>
            </div>
            <div class="col-lg-1 text-center">
<?php           // Usager
                echo "\t\t\t\t{$posts[$posts[$i]->idSujet - 1]->nomUsager}\n";
?>
            </div>
            <div class="col-lg-1 text-center">
<?php           // Réponses
                echo "\t\t\t\t{$nbReponsesParSujet[$posts[$i]->idSujet]}\n";
?>
            </div>
<?php
                if (($_SESSION["administrateur"])){
?>
            <div class="col-lg-1 text-center">
<?php           // Réponses
                echo "\t\t\t\t<a href='index.php?Posts&action=supprimer&id={$posts[$i]->idSujet}'>Supprimer</a>\n";
?>
            </div>
<?php
                }
?>
        </div>
<?php
            }
    }
?>
        <div class="row bg-light">
            <div class="col">
                <br><br>
<?php
    echo "\t\t\t\t<p><a href='index.php?Posts&action=formAjoutSujet'>Ajouter un sujet</a></p>";?>

            </div>
        </div>
        <div class="row bg-light">
            <div class="col">
                <p></p>
            </div>
        </div>
    </main>
