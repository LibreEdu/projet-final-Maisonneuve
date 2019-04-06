<?php

/**
 * Importation des données de la SAQ.
 *
 * @package  Vino
 * @author   Alexandre Pachot
 * @version  1.0
 */
final class Controleur_Importation extends Controleur
{
	/**
	 * @var string $nbBouteilles Le nombre de bouteilles de vin du site de la SAQ.
	 */
	private $_nbBouteillesWeb;


	/**
	 * @var object $modele_bouteille_SAQ Le modèle modele_bouteille_SAQ.
	 */
	private $modele_bouteille_SAQ;


	/**
	 * @var object $modele_type Le modèle Modele_Type.
	 */
	private $modele_type;


	/**
	 * @var boolean $_mettreAJour Lorsque la bouteille existe déjà dans la base, soit on fait une mise à jour (true) ou on ne fait rien (false).
	 */
	private $_mettreAJour;


	/**
	 * @var int $_indice Indice du début de la récupération des données.
	 */
	private $_indice;


	/**
	 * Vérification des droits d’administration et initialisation de l’attribut.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		// Vérification que la personne a bien les droits d’administration.
		Fonctions::est_admin();

		// Récupère le nombre de bouteilles de vin du site de la SAQ.
		$this->_nbBouteillesWeb = $this->recupererNbBouteilles();

		// Initialisation des modèles.
		$this->modele_bouteille_SAQ = $this->modele('Modele_bouteille_SAQ');
		$this->modele_type = $this->modele('Modele_type');

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

			case 'importer-js':
				$this->importer_js();
				break;
				
			default :
				trigger_error('Action invalide.');
		}
	}


	/**
	 * Affiche la page d’administration.
	 * 
	 * @return void
	 */
	private function index()
	{
		$donnees['prenom'] = $_SESSION['prenom'];
		$donnees['id_usager'] = $_SESSION['id_usager'];
		$donnees['nbBouteillesBD'] = $this->nbBouteillesBD();
		$donnees['nbBouteillesWeb'] = $this->_nbBouteillesWeb;
		$donnees['maxIndice'] = floor($this->_nbBouteillesWeb / 100) * 100;
		$this->afficheVue('admin/une-page', $donnees);
	}


	/**
	 * Vérifie les données du formulaire avant d’exécuter l’importation
	 * 
	 * @return booleen Vrai, s’il n’y a pas d’erreurs lors de l’importation.
	 */
	private function importer_js()
	{
		$body = json_decode(file_get_contents('php://input'));

		// On vérifie que les paramètres soient au format attendu.
		try {
			if (gettype($body->mettreAJour) == 'boolean') {
				$this->_mettreAJour = $body->mettreAJour;
			} else {
				throw new Exception('mettreAJour n’est pas un booléen');
			}
			if (gettype($body->indice) == 'string') {
				$this->_indice = (int)$body->indice;
			} else {
				throw new Exception('indice n’est pas une chaine de caractères');
			}
			if ($this->importer()) {
				echo "Importation finie";
			}
		} catch (Exception $e) {
			$log = new Log('admin');
			$log->ecrire("Controleur_importation::traite : " . $e->getMessage());
			echo "deconnexion";
		}
	}


	/**
	 * Récupère toutes les données du site web de la SAQ et les insère dans la base de données.
	 * 
	 * @return booleen Vrai, s’il n’y a pas d’erreurs lors de l’importation.
	 */
	private function importer()
	{
		for($i = $this->_indice; $i < $this->_nbBouteillesWeb; $i += 100) {
			$this->importerLot($i);
		}
		return true;
	}


	/**
	 * Renvoie le nombre de bouteilles qu’il y a dans la table bouteille_SAQ.
	 * 
	 * @return string Le nombre de bouteilles qu’il y a dans la table bouteille_SAQ.
	 */
	private function nbBouteillesBD()
	{
		return $this->modele_bouteille_SAQ->obtenir_total();
	}


	/**
	 * Retourne le nombre de bouteilles de vin du site de la SAQ.
	 * 
	 * @param integer $interval Nombre de jours à partir desquels la donnée stockée localement n’est plus valable.
	 * 
	 * @return string Le nombre de bouteilles de vin qu’il y a sur le site de la SAQ.
	 */
	private function recupererNbBouteilles($interval = 1)
	{
		$fichierJSON = new JSON('SAQ');
		$oNbBouteille = $fichierJSON->lire();
		if ($oNbBouteille) {
			$maintenant = new DateTime();
			$date = new DateTime($oNbBouteille->date_recup->date);
			$delta = $date->diff($maintenant)->format('%a');
			if ( $delta < $interval) {
				return $oNbBouteille->nb_bouteilles;
			}
		}

		$oNbBouteille = new stdClass();
		$oNbBouteille->nb_bouteilles = $this->recupererNbBouteillesWeb();
		$oNbBouteille->date_recup = new DateTime();
		$oJSON = new JSON('SAQ');
		$oJSON->ecrire($oNbBouteille);
		return $oNbBouteille->nb_bouteilles;
	}


	/**
	 * Récupère le nombre de bouteilles de vin du site de la SAQ.
	 * 
	 * @return string Le nombre de bouteilles de vin du site de la SAQ.
	 */
	private function recupererNbBouteillesWeb()
	{

		// On récupère les données de la page Web du site de la SAQ
		$page_web = $this->curl();

		// Transforme la page web en un élément DOM
		$xml = $this->html2dom($page_web);
		
		// Recherche tous les éléments qui ont une balise <div>
		$titre = $xml->getElementsByTagName('h1');

		// Il y a un seul 'h1', on récupère ses 'span'
		$elementLigne = $titre[0]->getElementsByTagName('span');

		// On récupère le troisième span et on recherche les chiffres
		preg_match("/\D*(\d*)\D*/", $elementLigne[2]->textContent, $nbBouteilles);

		// Le première élément est la chaine initial, le deuxième est la correspondance
		return $nbBouteilles[1];
	}


	/**
	 * Récupère les données HTML de la page Résultat de recherche de la SAQ.
	 * 
	 * @param integer $index Index de la première bouteille récupérée.
	 * @param integer $nombre_bouteilles Nombre de bouteilles de vin à récupérer.
	 * 
	 * @return string Page web récupérée par le client URL curl.
	 */
	private function curl($index = 0, $nombre_bouteilles = 1)
	{
		$url = 'https://www.saq.com/webapp/wcs/stores/servlet/SearchDisplay?storeId=20002&searchTerm=vin&categoryIdentifier=06&langId=-2&showOnly=product';

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
	 * Transforme un document HTML en document DOM.
	 * 
	 * @param string $html Document au format HTML
	 * 
	 * @return object Document DOM.
	 */
	private function html2dom($html)
	{
		$xml = new DOMDocument();

		// Activation du mode « recovery », c.-à-d. tentative d’analyser un document mal formé.
		$xml->recover = true;

		// Ne lance pas une DOMException en cas d’erreur.
		$xml->strictErrorChecking = false;

		// Chargement du code HTML à partir d’une chaîne de caractères (self::$_pageweb)
		// @ : permet de ne pas afficher l’éventuel message d’erreur que pourrait retourner la fonction
		@$xml->loadHTML($html);

		return $xml;
	}


	/**
	 * Récupère les données d’un lot de bouteilles du site web de la SAQ et les insère dans la base de données.
	 * 
	 * @param integer $index Index de la première bouteille à récupérer
	 * @param integer $nombre_bouteilles Nombre de bouteilles à récupérer
	 * 
	 * @return void
	 */
	private function importerLot($index = 0, $nombre_bouteilles = 100) {

		// On récupère les données de la page Web du site de la SAQ
		$page_web = $this->curl($index, $nombre_bouteilles);

		// Transforme la page web en un élément DOM
		$dom = $this->html2dom($page_web);

		// Recherche tous les éléments qui ont une balise <div>
		$noeuds = $dom->getElementsByTagName('div');

		foreach ($noeuds as $noeud) {
			if (strpos($noeud->getAttribute('class'), 'resultats_product') !== false) {
				$bouteille = $this->recupererDonnees($noeud);
				$retour = $this->ajouterDonnees($bouteille);
				// echo "coucou";
				// ob_flush();
				// flush();
			}
		}
	}


	/**
	 * Récupère les données d’une bouteille
	 * 
	 * @param object $noeud Nœud DOM
	 * 
	 * @return object $bouteille Un object de la classe Classe_Bouteille_SAQ.
	 */
	private function recupererDonnees($noeud) {
		// Objet qui va contenir mes informations de la bouteille
		$bouteille = new Classe_Bouteille_SAQ();

		// Recherche tous les éléments qui ont une balise <p>
		$paragraphes = $noeud->getElementsByTagName('p');

		foreach ($paragraphes as $paragraphe) {
			switch($paragraphe->getAttribute('class')) {
				// Nom de la bouteille et son millesime
				case 'nom':
					preg_match("/\r\n\s*(.*)(.{4})\r\n/", $paragraphe->textContent, $correspondances);
					if (intval($correspondances[2])) {
						$bouteille->nom = trim($correspondances[1]);
						$bouteille->millesime = intval($correspondances[2]);
					} else {
						$bouteille->nom = $correspondances[1] . $correspondances[2];
						$bouteille->millesime = NULL;
					}
					break;

				// Description de la bouteille
				case 'desc' :
					// Récupération des chaines de caractères excluant les retours charriot et les espaces de début
					preg_match_all("/\r\n\s*(.*)\r\n/", $paragraphe->textContent, $correspondances);

					// Récupération de l’information de la première ligne
					if (isset($correspondances[1][0])) {
						$bouteille->type = trim($correspondances[1][0]);
					}

					// Récupération de l’information de la deuxième ligne
					if (isset($correspondances[1][1])) {
						// Ex: "Arménie (République d'), 750 ml" ou "Arménie (République d'), 1,5 L"
						preg_match("/(.*),(.*)/", $correspondances[1][1], $corres);

						// Remplacement de l’apostrophe droite (') par l’apostrophe typographique (’)
						$bouteille->pays = str_replace("'", '’', $corres[1]);

						// Remplacement du séparateur décimal, format base de données
						$bouteille->format = trim($corres[2]);
					}

					// Récupération de l’information de la troisième ligne
					if (isset($correspondances[1][2])) {
						preg_match("/\d{8}/", $correspondances[1][2], $corres);
						$bouteille->code_saq =  $corres[0];
					}
					break;
			}
		}
		
		// Récupération du prix
		$cellules = $noeud->getElementsByTagName("td");
		foreach ($cellules as $cellule) {
			if ($cellule->getAttribute('class') == 'price') {
				preg_match("/(\d*),(\d*).*$/", trim($cellule->textContent), $correspondances);
				$bouteille->prix = $correspondances[1] . "." . $correspondances[2];
			}
		}
		return $bouteille;
	}



	/**
	 * Ajoute les données dans la base
	 * 
	 * @param object $bouteille Un object de la classe Classe_Bouteille_SAQ.
	 * 
	 * @return // À VÉRIFIER
	 */

	private function ajouterDonnees($bouteille) {
		// On veut vérifier si le type de vin (ex. : Vin rouge) est déjà dans la table des types

		// On récupère les types de vin qui correspond au type de la bouteille
		$type = $this->modele_type->obtenir_type($bouteille->type);

		// S’il y a un enregistrement, on récupère son id
		// Sinon, on l’insère et on récupère son id
		if ($type) {
			$bouteille->id_type = (int)$type[0]->id_type;
		} else {
			$bouteille->id_type = (int)$this->modele_type->ajouter_type($bouteille->type);
		}

		// Si la bouteille est présente, on la met éventuellement à jour sinon on l’insère.
		if ($this->modele_bouteille_SAQ->estPresent($bouteille->code_saq)) {
			if ($this->_mettreAJour)
			{
				return $this->modele_bouteille_SAQ->mettreAJour($bouteille);
			}
		} else {
			return $this->modele_bouteille_SAQ->inserer($bouteille);
		}
	}
}
