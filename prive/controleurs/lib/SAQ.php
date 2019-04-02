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
	 * @var string $nbBouteilles Le nombre de bouteilles de vin du site de la SAQ.
	 */
	private $_nbBouteilles;


	/**
	 * Vérification des droits d’administration et initialisation de l’attribut.
	 * 
	 * Depuis qu’on stocke la variable dans un fichier JSON, il n’y a plus d’intérêt de faire appel à un singleton !
	 * Y en avait-il un avanè ?
	 * 
	 * @return void
	 */
	public function __construct()
	{
		// Récupère le nombre de bouteilles de vin du site de la SAQ.
		$this->_nbBouteilles = $this->recupererNbBouteille();
	}


	/**
	 * Récupère sur le site de la SAQ le nombre de bouteilles de vin.
	 * 
	 * @param integer $interval Nombre de jours au bout duquel, on considère que la donnée stockée localement n’est plus valable.
	 * 
	 * @return string Le nombre de bouteilles de vin qu’il y a sur le site de la SAQ.
	 */
	private function recupererNbBouteille($interval = 1)
	{
		$fichierJSON = new JSON('SAQ');
		$oNbBouteille = $fichierJSON->lire();
		if ($oNbBouteille) {
			$maintenant = new DateTime();
			$date = new DateTime($oNbBouteille->dateRecup->date);
			$delta = $date->diff($maintenant)->format('%a');
			if ( $delta < $interval) {
				return $oNbBouteille->nbBouteille;
			}
		}

		$oNbBouteille = new stdClass();
		$oNbBouteille->nbBouteille = $this->nbBouteilles();
		$oNbBouteille->dateRecup = new DateTime();
		$oJSON = new JSON('SAQ');
		$oJSON->ecrire($oNbBouteille);
		return $oNbBouteille->nbBouteille;
	}

	/**
	 * Renvoie le nombre de bouteilles de vin du site de la SAQ.
	 * 
	 * @return string Le nombre de bouteilles de vin du site de la SAQ.
	 */
	public function nbBouteiles()
	{
		return $this->_nbBouteilles;
	}


	/**
	 * Récupère les données HTML de la page Résultat de recherche de la SAQ.
	 * 
	 * @param integer $index Index de la première bouteille récupérée.
	 * @param integer $nombre_bouteilles Nombre de bouteilles de vin à récupérer.
	 * 
	 * @return string Page web récupérée par le client URL curl.
	 */
	private function curl($index = 0, $nombre_bouteilles = 1) {

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
	private function nbBouteilles() {

		// On récupère les données de la page Web du site de la SAQ
		$page_web = $this->curl();

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



	// public function getProduits($debut = 0, $nombre = 100) {
	// 	$doc = new DOMDocument();

	// 	// Activation du mode « recovery », c.-à-d. tentative d’analyser un document mal formé.
	// 	$doc->recover = true;

	// 	// Ne lance pas une DOMException en cas d’erreur.
	// 	$doc->strictErrorChecking = false;

	// 	// Chargement du code HTML à partir d’une chaîne de caractères (self::$_pageweb)
	// 	// @ : permet de ne pas afficher l’éventuel message d’erreur que pourrait retourner la fonction
	// 	@$doc->loadHTML(self::$_pageweb);

	// 	// Recherche tous les éléments qui ont une balise <div>
	// 	$elements = $doc->getElementsByTagName('div');

	// 	$nombreDeProduits = 0;

	// 	foreach ($elements as $noeud) {
	// 		if (strpos($noeud->getAttribute('class'), 'resultats_product') !== false) {
	// 			$info = self::recupereInfo($noeud);
	// 			//var_dump($info);
	// 			$retour = $this->ajoutProduit($info);
	// 			if ($retour->succes == false) {
	// 				$retour->raison;
	// 			} else {
	// 				$nombreDeProduits++;
	// 			}
	// 		}
	// 	}
	// 	return $nombreDeProduits;
	// }
}
