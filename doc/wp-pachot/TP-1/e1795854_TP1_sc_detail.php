<?php

/** Détail de l’annonce. */


add_shortcode("e1795854_TP1_detail", "e1795854_TP1__detail");


/**
 * Traitements pour le détail.
 *
 * @param void
 * @return string 	La page de modification
 */
 function e1795854_TP1__detail()
{
    if(e1795854_TP1_verif_settings())
    {
        ob_start();            				// Enclenche la temporisation de sortie (fonction PHP).
        e1795854_TP1_verif_form("detail");	// Affichage du formulaire.
        return ob_get_clean(); 				// Lit le contenu courant du tampon de sortie puis l’efface (fonction PHP).
    }
    else {
?>
<p>Vous n’avez pas accès à cette page.</p>
<?php
    }
}

?>
