<?php

/**
 * Nombre de bouteilles qu’on peut importer.
 *
 * @package  Vino
 * @author   Alexandre Pachot
 * @version  1.0
 */
class NbBouteilles
{
	/**
	 * @var string $url_SAQ Nombre de bouteilles qu’on peut importer.
	 */
	public static $nbBouteilles;


	/**
	 * @var object $instance Une instance de la classe.
	 */
	private static $instance;


	/**
	 * S’il n’y a aucune instance de la classe, une instance est lancée.
	 * 
	 * @return mixed Soit une instance de la classe, soit rien.
	 */
	public static function getInstance()
	{
		if ( is_null( self::$instance ) )
		{
			self::$instance = new self();
			self::$nbBouteilles = self::nbBouteillesSAQ();
		}
		return self::$instance;
	}

	/**
	 * Retourne ee nombre de bouteilles de vin de la SAQ.
	 * 
	 * @return string Le nombre de bouteilles de vin de la SAQ.
	 */
	public static function obtenirNbBouteilles()
	{
		return self::$nbBouteilles;
	}


	/**
	 * Récupère les données HTML de la page Résultat de recherche de la SAQ.
	 * 
	 * @param integer $index Index de la première bouteille récupérée.
	 * @param integer $nombre_bouteilles Nombre de bouteilles de vin à récupérer.
	 * 
	 * @return string Page web récupérée par le client URL curl.
	 */
	public static function curl($index = 0, $nombre_bouteilles = 1) {

		$url = 'https://www.saq.com/webapp/wcs/stores/servlet/SearchDisplay?storeId=20002&searchTerm=vin';

		// Initialisation du gestionnaire du client URL.
		$gc = curl_init();

		// URL à récupérer.
		curl_setopt($gc, CURLOPT_URL, $url . '&beginIndex=' . $index . '&pageSize=' . $nombre_bouteilles);

		// Retourne directement le transfert sous forme de chaine au lieu de l’afficher directement.
		curl_setopt($gc, CURLOPT_RETURNTRANSFER, true);

		// Pour que le php laisse accesse a https
		curl_setopt($gc, CURLOPT_SSL_VERIFYPEER, false);

		// Exécution de la session cURL.
		$page_web = curl_exec($gc);

		// Fermeture de la session.
		curl_close($gc);

		return $page_web;
	}


	/**
	 * Récupère le nombre de bouteilles de vin du site de la SAQ.
	 * 
	 * @return string Le nombre de bouteilles de vin du site de la SAQ.
	 */
	public static function nbBouteillesSAQ() {

		// On récupère les données de la page Web du site de la SAQ
		$page_web = self::curl();

		$xml = new DOMDocument();

		// Activation du mode « recovery », c.-à-d. tentative d’analyser un document mal formé.
		$xml->recover = true;

		// Ne lance pas une DOMException en cas d’erreur.
		$xml->strictErrorChecking = false;

		// Chargement du code HTML à partir d’une chaîne de caractères (self::$_pageweb)
		// @ : permet de ne pas afficher l’éventuel message d’erreur que pourrait retourner la fonction
		@$xml->loadHTML($page_web);

		// Recherche tous les éléments qui ont une balise <div>
		$titre = $xml->getElementsByTagName('h1');

		// Il y a un seul 'h1', on récupère ses 'span'
		$elementLigne = $titre[0]->getElementsByTagName('span');

		// On récupère le troisième span et on recherche les chiffres
		preg_match("/\D*(\d*)\D*/", $elementLigne[2]->textContent, $nbBouteilles);

		// Le première élément est la chaine initial, le deuxième est la correspondance
		return $nbBouteilles[1];
	}

}
