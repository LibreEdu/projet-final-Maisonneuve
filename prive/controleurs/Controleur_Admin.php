<?php

/**
 * Fonctionnalités de l’administrateur.
 *
 * @package  Vino
 * @author   Alexandre Pachot
 * @version  1.0
 */
final class Controleur_Admin extends Controleur
{
	/**
	 * @var string $url_SAQ URL de la SAQ qui sert à l’importation des bouteilles.
	 */
	private $_url_SAQ;


	/**
	 * @var string $_page_web Page web récupérée par le client URL curl.
	 */
	private $_page_web;


	/**
	 * Initialisation de l’attribut
	 * 
	 * @return void
	 */
	public function __construct()
	{
		$this->url_SAQ = 'https://www.saq.com/webapp/wcs/stores/servlet/SearchDisplay?storeId=20002&searchTerm=vin';
	}


	/**
	 * Récupère la requête de l’utilisateur afin de la traiter.
	 * 
	 * @param array $params Requête de l'utilisateur ($_REQUEST).
	 * 
	 * @return void
	 */
	public function traite(array $params)
	{
		if ( ! ( isset($_SESSION["admin"]) && $_SESSION["admin"] == true) )
		{
			header( 'Location: ' . base_url() );
		}
		switch($params['action'])
		{
			case 'index':
				$this->index();
				break;
			case 'importer':
				$this->importer();
				break;
			default :
				trigger_error('Action invalide.');
		}
	}


	/**
	 * Affichage de la page par défaut.
	 * 
	 * @return void
	 */
	public function index()
	{
		$donnees['prenom'] = $_SESSION["prenom"];
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-admin');
		$this->afficheVue('admin/principal', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}

	public function importer()
	{
		echo 'coucou';

		$this->curl();
		var_dump($this->_page_web);
		// var_dump($_POST);
		// $import = $this->getProduits(0, 10);
		// var_dump($import);
	}

	/**
	 * Récupère les données HTML de la page Résultat de recherche de la SAQ.
	 * 
	 * @param integer $debut Index de la première bouteille récupérée.
	 * @param integer $quantite Quantité de bouteilles de vin à récupérer.
	 * 
	 * @return void
	 */
	private function curl($debut = 0, $quantite = 1) {
		// Initialisation du gestionnaire du client URL.
		$gc = curl_init();

		// URL à récupérer.
		curl_setopt($gc, CURLOPT_URL, $this->url_SAQ . '&beginIndex=' . $debut . '&pageSize=' . $quantite);

		// Retourne directement le transfert sous forme de chaine au lieu de l’afficher directement.
		curl_setopt($gc, CURLOPT_RETURNTRANSFER, true);

		// Pour que le php laisse accesse a https
		curl_setopt($gc, CURLOPT_SSL_VERIFYPEER, false);

		// Exécution de la session cURL.
		$this->_page_web = curl_exec($gc);

		// Fermeture de la session.
		curl_close($gc);
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
