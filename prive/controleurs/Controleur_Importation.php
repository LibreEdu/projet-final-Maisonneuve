<?php

/**
 * Fonctionnalités de l’administrateur.
 *
 * @package  Vino
 * @author   Alexandre Pachot
 * @version  1.0
 */
final class Controleur_Importation extends Controleur
{
	/**
	 * @var object $_log Fichier de log.
	 */
	private $_log;


	/**
	 * @var string $url_SAQ URL de la SAQ qui sert à l’importation des bouteilles.
	 */
	private $_url_SAQ;


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
		// Déclaration du fichier de log.
		$this->_log = new Log('admin');

		// Vérification que la personne a bien les droits d’administration.
		$this->est_admin();

		// URL qui va servir à l’importation des bouteilles de vin de la SAQ.
		$this->url_SAQ = 'https://www.saq.com/webapp/wcs/stores/servlet/SearchDisplay?storeId=20002&searchTerm=vin';
	}


	/**
	 * Vérification que la personne qui accède à cette classe a les droits d’administrateur.
	 * 
	 * Si la personne n’est pas admin, alors elle sera redirigée vers la page de déconnexion
	 * 
	 * @return void
	 */
	private function est_admin() {
		// Pour que la personne soit admin,
		// il faut d’une part qu’il existe une variable de session qui s’appelle admin
		// et d’autre part que cette variable soit à Vrai.
		if ( ! ( isset($_SESSION['admin']) && $_SESSION['admin'] == true) )
		{
			// Récupération de l’identifiant de l’usager qui veut jouer au malin !
			$id_usager = (isset($_SESSION['id_usager'])) ? $_SESSION['id_usager'] : 'personne non connectée';

			// On garde une trace de la tentative d’effraction.
			$message_erreur = "Tentative de connexion. Id_usager = $id_usager\n";
			$this->_log->ecriture($message_erreur);

			// Redirection vers la page de déconnexion
			header('Location: ' . site_url('login&action=logout') );
		}
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
		$donnees['prenom'] = $_SESSION['prenom'];

		$this->afficheVue('admin/une-page', $donnees);
		// $this->afficheVue('admin/principal', $donnees);
		// $this->afficheVue('modeles/bas-de-page');
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
	 * @param integer $index Index de la première bouteille récupérée.
	 * @param integer $nombre_bouteilles Nombre de bouteilles de vin à récupérer.
	 * 
	 * @return void
	 */
	private function curl($index = 0, $nombre_bouteilles = 1) {
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
