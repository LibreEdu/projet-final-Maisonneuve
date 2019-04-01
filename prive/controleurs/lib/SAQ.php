<?php

/**
 * Récupère les informations du site Web de la SAQ
 *
 * @package  Vino
 * @author   Alexandre Pachot
 * @version  1.0
 */
class SAQ extends NbBouteilles
{
	/**
	 * @var object $modele_bouteille_saq Le modèle Modele_Bouteille_SAQ.
	 */
	private $_nbBouteillesSAQ;


	/**
	 * Vérification des droits d’administration et initialisation de l’attribut.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		// Vérification que la personne a bien les droits d’administration.
		est_admin();

		$this->_nbBouteillesSAQ = parent::getInstance()->obtenirNbBouteilles();
	}


	/**
	 * Retourne le nombre de bouteilles SAQ qu’on peut importer.
	 * 
	 * @return void
	 */
	public function obtenirNbBouteiles()
	{
		return $this->_nbBouteillesSAQ;
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
