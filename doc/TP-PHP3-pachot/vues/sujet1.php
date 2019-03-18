        <div class="row bg-light">
            <div class="col">
                <p></p>
            </div>
        </div>
        <div class="row text-center bg-light">
            <div class="col">
<?php
    // Affichage du titre du sujet
    echo "\t\t\t\t<h3 class='font-italic'>" . htmlspecialchars($data['sujet']->titre) . "</h3>\n";
    echo "\t\t\t\t<h6> Par : <span class='font-italic'>" . $data["sujet"]->nomUsager . "</span></h6>\n";
?>
            </div>
        </div>
        <div class="row text-center bg-light">
            <div class="col text-left">
<?php
    // Affichage du sujet
    echo "\t\t\t\t<p>" . htmlspecialchars($data["sujet"]->texte) . "</p>\n";

    // Affichage des commentaires s’il y en a
    if(count($data["reponses"]) > 0){
?>
                <table class="col table-striped">
                    <tr>
                        <th width="20%">Usager</th>
                        <th>Réponse(s)</th>
                    </tr>
<?php

        foreach ($data["reponses"] as $reponse) {
?>
                    <tr>
<?php
            echo "\t\t\t\t\t\t<td>" . htmlspecialchars($reponse->nomUsager) ."</td>\n";
            echo "\t\t\t\t\t\t<td>" . htmlspecialchars($reponse->texte) . "</td>\n";
?>
                    </tr>
<?php
        }

?>
                </table>
<?php
    }
    // Affichage d’un message dans le cas ou il n'y a pas de commentaire
    else{
        echo "\t\t\t<h5>Il n’y a aucune réponse à ce sujet.</h5>\n";
    }
?>
            </div>
        </div>
