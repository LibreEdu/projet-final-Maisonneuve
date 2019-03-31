<?php

/**
 * Récupère les informations du site Web de la SAQ
 *
 * @package  Vino
 * @author   Alexandre Pachot
 * @version  1.0
 */
class SAQ
{
	/**
	 * @var string $url_SAQ URL de la SAQ qui sert à l’importation des bouteilles.
	 */
	public $_url_SAQ;


	/**
	 * @var string $_page_web Page web récupérée par le client URL curl.
	 */
	private $_page_web;


	/**
	 * Vérification des droits d’administration et initialisation de l’attribut.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		// Vérification que la personne a bien les droits d’administration.
		est_admin();

		// URL qui va servir à l’importation des bouteilles de vin de la SAQ.
		$this->url_SAQ = 'https://www.saq.com/webapp/wcs/stores/servlet/SearchDisplay?storeId=20002&searchTerm=vin';
	}


	/**
	 * Récupère les données HTML de la page Résultat de recherche de la SAQ.
	 * 
	 * @param integer $index Index de la première bouteille récupérée.
	 * @param integer $nombre_bouteilles Nombre de bouteilles de vin à récupérer.
	 * 
	 * @return string Page web récupérée par le client URL curl.
	 */
	public function curl($index = 0, $nombre_bouteilles = 1) {
		// Initialisation du gestionnaire du client URL.
		$gc = curl_init();

		// URL à récupérer.
		curl_setopt($gc, CURLOPT_URL, $this->url_SAQ . '&beginIndex=' . $index . '&pageSize=' . $nombre_bouteilles);

		// Retourne directement le transfert sous forme de chaine au lieu de l’afficher directement.
		curl_setopt($gc, CURLOPT_RETURNTRANSFER, true);

		// Pour que le php laisse accesse a https
		curl_setopt($gc, CURLOPT_SSL_VERIFYPEER, false);

		// Exécution de la session cURL.
		$this->_page_web = curl_exec($gc);

		// Fermeture de la session.
		curl_close($gc);
	}

	/**
	 * Récupère le nombre de bouteilles de vin du site de la SAQ.
	 * 
	 * @return string Le nombre de bouteilles de vin du site de la SAQ.
	 */
	public function nbBouteillesWeb() {
		$this->curl();

		$xml = new DOMDocument();

		// Activation du mode « recovery », c.-à-d. tentative d’analyser un document mal formé.
		$xml->recover = true;

		// Ne lance pas une DOMException en cas d’erreur.
		$xml->strictErrorChecking = false;

		// Chargement du code HTML à partir d’une chaîne de caractères (self::$_pageweb)
		// @ : permet de ne pas afficher l’éventuel message d’erreur que pourrait retourner la fonction
		@$xml->loadHTML($this->_page_web);

		// Recherche tous les éléments qui ont une balise <div>
		$titre = $xml->getElementsByTagName('h1');

		// Il y a un seul 'h1', on récupère ses 'span'
		$elementLigne = $titre[0]->getElementsByTagName('span');

		// On récupère le troisième span et on recherche les chiffres
		preg_match("/\D*(\d*)\D*/", $elementLigne[2]->textContent, $nbBouteilles);

		// Le première élément est la chaine initial, le deuxième est la correspondance
		return $nbBouteilles[1];
	}

	public function getProduits($debut = 0, $nombre = 100) {
		$doc = new DOMDocument();

		// Activation du mode « recovery », c.-à-d. tentative d’analyser un document mal formé.
		$doc->recover = true;

		// Ne lance pas une DOMException en cas d’erreur.
		$doc->strictErrorChecking = false;

		// Chargement du code HTML à partir d’une chaîne de caractères (self::$_pageweb)
		// @ : permet de ne pas afficher l’éventuel message d’erreur que pourrait retourner la fonction
		@$doc->loadHTML(self::$_pageweb);

		// Recherche tous les éléments qui ont une balise <div>
		$elements = $doc->getElementsByTagName('div');

		$nombreDeProduits = 0;

		foreach ($elements as $noeud) {
			if (strpos($noeud->getAttribute('class'), 'resultats_product') !== false) {
				$info = self::recupereInfo($noeud);
				//var_dump($info);
				$retour = $this->ajoutProduit($info);
				if ($retour->succes == false) {
					$retour->raison;
				} else {
					$nombreDeProduits++;
				}
			}
		}
		return $nombreDeProduits;
	}
}
