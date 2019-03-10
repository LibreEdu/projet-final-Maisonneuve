<?php
/**
 * Class MonSQL
 * Classe qui génère ma connection à MySQL à travers un singleton
 *
 *
 * @author Alexandre Pachot
 * @version 1.0
 *
 *
 *
 */
class SAQ extends Modele {

	const DUPLICATION = 'duplication';
	const ERREURDB = 'erreurdb';

	private static $_pageweb;
	private static $_status;
	private $stmt;

	// public function __construct() {
	// 	parent::__construct();
	// 	if (!($this -> stmt = $this -> _db -> prepare("INSERT INTO vino__bouteille(nom, type, image, code_saq, pays, description, prix_saq, url_saq, url_img, format) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
	// 		echo "Echec de la préparation : (" . $mysqli -> errno . ") " . $mysqli -> error;
	// 	}
	// }

	/**
	 * getProduits
	 * @param int $debut
	 * @param int $nombre
	 */
	public function getProduits($debut = 0, $nombre = 100) {
		// Initialisation du gestionnaire du client URL.
		$gc = curl_init();

		// URL à récupérer.
		curl_setopt($gc, CURLOPT_URL, 'https://www.saq.com/webapp/wcs/stores/servlet/SearchDisplay?storeId=20002&searchTerm=vin&beginIndex=' . $debut . '&pageSize=' . $nombre);

		// Retourne directement le transfert sous forme de chaine au lieu de l’afficher directement.
		curl_setopt($gc, CURLOPT_RETURNTRANSFER, true);

		// Exécution de la session cURL.
		self::$_pageweb = curl_exec($gc);

		// Lecture du dernier code de réponse.
		self::$_status = curl_getinfo($gc, CURLINFO_HTTP_CODE);

		// Fermeture de la session.
		curl_close($gc);

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
				var_dump($info);die;
				$retour = $this -> ajouteProduit($info);
				if ($retour -> succes == false) {
					echo "erreur : " . $retour -> raison . "<br>";
					echo "<pre>";
					var_dump($info);
					echo "</pre>";
					echo "<br>";
				} else {
					$nombreDeProduits++;
				}
			}
		}

		return $nombreDeProduits;
	}

	private function get_inner_html($node) {
		$innerHTML = '';
		$children = $node -> childNodes;
		foreach ($children as $child) {
			$innerHTML .= $child -> ownerDocument -> saveXML($child);
		}

		return $innerHTML;
	}

	private function recupereInfo($noeud) {
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
						preg_match("/(.*),\D*(\d*(,\d*)?)\W*(\w*)/", $correspondances[1][1], $corres);

						// Remplacement de l’apostrophe droite (') par l’apostrophe typographique (’)
						$info->pays = str_replace("'", '’', $corres[1]);

						// Remplacement du séparateur décimal, format base de données
						$info->quantite = str_replace(',', '.', $corres[2]);

						$info->unite = $corres[4];
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

	private function ajouteProduit($bte) {
		$retour = new stdClass();
		$retour -> succes = false;
		$retour -> raison = '';

		// var_dump($bte);die;
		// Récupère le type
		$rows = $this -> _db -> query("select id from vino__type where type = '" . $bte -> desc -> type . "'");
		
		if ($rows -> num_rows == 1) {
			$type = $rows -> fetch_assoc();
			// var_dump($type);
			$type = $type['id'];

			$rows = $this -> _db -> query("select id from vino__bouteille where code_saq = '" . $bte -> desc -> code_SAQ . "'");
			// var_dump($info);
			
			if ($rows -> num_rows < 1) {
				$this -> stmt -> bind_param("sissssssss", $bte -> nom, $type, $bte -> img, $bte -> desc -> code_SAQ, $bte -> desc -> pays, $bte -> desc -> texte, $bte -> prix, $bte -> url, $bte -> img, $bte -> desc -> format);
				$retour -> succes = $this -> stmt -> execute();

			} else {
				$retour -> succes = false;
				$retour -> raison = self::DUPLICATION;
			}
		} else {
			$retour -> succes = false;
			$retour -> raison = self::ERREURDB;

		}
		return $retour;

	}

}
?>