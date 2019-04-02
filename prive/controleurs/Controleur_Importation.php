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
	 * @var object $modele_bouteille_saq Le modèle Modele_Bouteille_SAQ.
	 */
	private $modele_bouteille_saq;


	/**
	 * Vérification des droits d’administration et initialisation de l’attribut.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		// Initialisation du modèle Bouteille SAQ.
		$this->modele_bouteille_saq = $this->modele('modele_bouteille_saq');

		// Vérification que la personne a bien les droits d’administration.
		est_admin();
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
		$SAQ = new SAQ();
		$donnees['prenom'] = $_SESSION['prenom'];
		$donnees['nbBouteillesBD'] = $this->nbBouteillesBD();
		$donnees['nbBouteillesWeb'] = $SAQ->nbBouteiles();
		$this->afficheVue('admin/une-page', $donnees);
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





	public function importer()
	{
		// echo 'coucou';

		
		// var_dump($this->_page_web);
		// $aa = $this->nbBouteillesWeb();
		// var_dump($_POST);
		// $import = $this->getProduits(0, 10);
		// var_dump($aa);
	}
}