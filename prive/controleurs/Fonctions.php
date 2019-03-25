<?php

/**
 * Renvoie l’URL complète de la racine du site Web.
 *
 * @example  href='<?php echo base_url(); ?>css/vino.css'
 * 
 * @return string L’URL cpmplète du site Web
 */
function base_url()
{
	return BASEURL;
}

/**
 * Renvoie l’URL complète de la racine du site Web avec l’appel du contrôleur et de la méthode.
 *
 * @example header('Location: ' . site_url('login&action=logout') )
 * 
 * @param string L’URL du site, ce qui se trouve après le « index.php? »
 * @return string LURL complète de la racine du site Web avec l’appel du contrôleur et de la méthode
 */
function site_url($url)
{
	return base_url() . 'index.php?' . $url;
}