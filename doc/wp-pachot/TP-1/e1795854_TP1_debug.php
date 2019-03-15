<?php

/** Fonction de débogage. */


/**
 * Affichage du contenu d’une variable
 *
 * @param $var      Variable à afficher
 * @return void
 */
function dump($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}

?>
