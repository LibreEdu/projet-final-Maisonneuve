<?php
/**
 * @package  Vino
 * @author   Alexandre Pachot
 * @version  1.0
 */


/**
 * Renvoie l’URL complète de la racine du site Web.
 * 
 * @return string L’URL complète de la racine du site Web.
 */
function base_url()
{
	return BASEURL;
}


/**
 * Renvoie l’URL complète de la racine du site Web avec l’appel du contrôleur et de la méthode.
 * 
 * @param string L’URL du site, ce qui se trouve après le « index.php? »
 * 
 * @return string L’URL complète de la racine du site Web avec l’appel du contrôleur et de la méthode.
 */
function site_url( $url)
{
	return base_url() . 'index.php?' . $url;
}
