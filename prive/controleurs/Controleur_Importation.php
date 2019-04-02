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
	 * @var string $nbBouteilles Le nombre de bouteilles de vin du site de la SAQ.
	 */
	private $_nbBouteillesWeb;


	/**
	 * @var object $modele_bouteille_saq Le modèle Modele_Bouteille_SAQ.
	 */
	private $modele_bouteille_saq;


	/**
	 * @var object $modele_type Le modèle Modele_Type.
	 */
	private $modele_type;


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
		$this->modele_bouteille_saq = $this->modele('modele_bouteille_saq');
		$this->modele_type = $this->modele('modele_type');

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
	 * Affiche la page d’administration.
	 * 
	 * @return void
	 */
	private function index()
	{
		$donnees['prenom'] = $_SESSION['prenom'];
		$donnees['nbBouteillesBD'] = $this->nbBouteillesBD();
		$donnees['nbBouteillesWeb'] = $this->_nbBouteillesWeb;
		$this->afficheVue('admin/une-page', $donnees);
	}


	/**
	 * Récupère toutes les données du site web de la SAQ et les insère dans la base de données.
	 * 
	 * @return void
	 */
	private function importer() {
		// $this->importerLot(0, 1);
		$this->ajouterDonnees();
	}


	/**
	 * Renvoie le nombre de bouteilles qu’il y a dans la table bouteille_SAQ.
	 * 
	 * @return string Le nombre de bouteilles qu’il y a dans la table bouteille_SAQ.
	 */
	private function nbBouteillesBD()
	{
		return $this->modele_bouteille_saq->obtenir_total();
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
				$donnees = $this->recupererDonnees($noeud);
				// var_dump($donnees);die;
				$retour = $this->ajouterDonnees($donnees);
				//var_dump($retour);die;
				if ($retour->succes == false) {
					echo "erreur : " . $retour->raison . "<br>";
					echo "<pre>";
					//var_dump($info);
					echo "</pre>";
					echo "<br>";
				} else {
					// $nombreDeProduits++;
				}
			}
		}
	}


	/**
	 * Récupère les données d’une bouteille
	 * 
	 * @param object $noeud Nœud DOM
	 * 
	 * @return object Les données de la bouteille
	 */
	private function recupererDonnees($noeud) {
		// Objet qui va contenir mes informations de la bouteille
		$info = new stdClass();

		// Recherche tous les éléments qui ont une balise <p>
		$paragraphes = $noeud->getElementsByTagName('p');

		foreach ($paragraphes as $paragraphe) {
			switch($paragraphe->getAttribute('class')) {
				// Nom de la bouteille et son millesime
				case 'nom':
					preg_match("/\r\n\s*(.*)(.{4})\r\n/", $paragraphe->textContent, $correspondances);
					if (intval($correspondances[2])) {
						$info->nom = trim($correspondances[1]);
						$info->millesime = intval($correspondances[2]);
					} else {
						$info->nom = $correspondances[1] . $correspondances[2];
						$info->millesime = NULL;
					}
					break;

				// Description de la bouteille
				case 'desc' :
					// Récupération des chaines de caractères excluant les retours charriot et les espaces de début
					preg_match_all("/\r\n\s*(.*)\r\n/", $paragraphe->textContent, $correspondances);

					// Récupération de l’information de la première ligne
					if (isset($correspondances[1][0])) {
						$info->type = trim($correspondances[1][0]);
					}

					// Récupération de l’information de la deuxième ligne
					if (isset($correspondances[1][1])) {
						// Ex: "Arménie (République d'), 750 ml" ou "Arménie (République d'), 1,5 L"
						preg_match("/(.*),(.*)/", $correspondances[1][1], $corres);

						// Remplacement de l’apostrophe droite (') par l’apostrophe typographique (’)
						$info->pays = str_replace("'", '’', $corres[1]);

						// Remplacement du séparateur décimal, format base de données
						$info->format = $corres[2];
					}

					// Récupération de l’information de la troisième ligne
					if (isset($correspondances[1][2])) {
						preg_match("/\d{8}/", $correspondances[1][2], $corres);
						$info->code_SAQ =  $corres[0];
					}
					break;
			}
		}
		
		// Récupération du prix
		$cellules = $noeud->getElementsByTagName("td");
		foreach ($cellules as $cellule) {
			if ($cellule->getAttribute('class') == 'price') {
				preg_match("/(\d*),(\d*).*$/", trim($cellule->textContent), $correspondances);
				$info->prix = $correspondances[1] . "." . $correspondances[2];
			}
		}
		return $info;
	}

	// private function ajouterDonnees($bouteille) {
	private function ajouterDonnees() {
		// Vérifie si le type de vin existe déjà dans la table Type
		// $type = $this->modele_type->obtenir_type($bouteille->type);

		$type = $this->modele_type->obtenir_type('Vin Rouge');
		
		if ($type) {
			$id_type = $type[0]->id_type;
		} else {
			echo "KO";
		}
		var_dump($id_type);
		die;



		$retour = new stdClass();
		$retour -> succes = false;
		$retour -> raison = '';
		$dernierId = "";

		// Récupère le type reçu en paramètre 
		$rangeeType = $this->_bd->query("SELECT id FROM vino_type WHERE libelle = '" . $bte->type . "'");
		
		// Vérifier si les rangées ne sont pas vides		
		if ($rangeeType->num_rows == 1 ) {	
			// Récupère le id de type de vin
			$id_type = $rangeeType->fetch_assoc();
			$id_type = $id_type['id'];

		} else {
			// Ajouter le type dans la table de type
			$this->_stmt_type->bind_param("s", $bte->type);		
			$this->_stmt_type->execute();			
			$id_type = $this->_stmt_type->insert_id;
		}
		
		// Récupère le code_saq pour vérifier après si il existe dans la table ou non
		 $rangeeCodeSaq = $this->_bd->query("SELECT id FROM vino_bouteille_saq WHERE code_saq = '" . $bte->code_SAQ . "'");

		//Si le code_saq n'existe pas dans le tableau
		if ($rangeeCodeSaq->num_rows < 1) {
			
			$this->_stmt_bouteille_saq->bind_param("siissii", $bte->nom, $bte->millesime, $id_type, $bte->pays, $bte->format, $bte->code_SAQ, $bte->prix);
			echo "<br>dernier id insere apres cherche codeSAQ ".$id_type;

			$retour->succes = $this->_stmt_bouteille_saq->execute();
			echo "<br>dernier id insere apres execute ".$id_type; 

		} else {
			$retour->succes = false;
			$retour->raison = self::DUPLICATION;
		}
	return $retour;
	}

}
