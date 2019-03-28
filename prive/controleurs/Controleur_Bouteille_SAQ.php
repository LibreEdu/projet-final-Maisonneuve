<?php

/**
 * Gestion des bouteilles de la SAQ.
 *
 * @package  Vino
 * @author   José Ignacio Delgado
 * @author   Alexandre Pachot
 * @version  1.0
 */
class Controleur_Bouteille_SAQ extends Controleur
{
	/**
	 * @var object $modele_bouteille_saq Le modèle Modele_Bouteille_SAQ.
	 */
	private $modele_bouteille_saq;
	
	public function __construct()
	{
		$this->modele_bouteille_saq = $this->modele('modele_bouteille_SAQ');
	}

	public function traite(array $params)
	{
		// On vérifie que l’usagé est bien connecté
		if ( ! isset($_SESSION['id_usager']) )
		{
			header('Location: ' . base_url() );
		}

		switch($params['action'])
		{
			case 'saisie-semi-automatique':
				$this->saisie_semi_automatique();
				break;
			case 'liste_form':
				$this->liste_form();
				break;
			case 'ajouter_liste':
				$this->ajouter_liste();
				break;

			default :
				trigger_error('Action invalide.');
		}
	}

	public function saisie_semi_automatique()
	{
		$body = json_decode(file_get_contents('php://input'));
		$listeBouteilles = $this->modele_bouteille_saq->autocomplete($body->nom);
		echo json_encode($listeBouteilles);
	}

	public function liste_form()
	{
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('bouteille/formulaire.1');
		$this->afficheVue('modeles/bas-de-page');
	}

	public function ajouter_liste()
	{
		$this->modele_bouteille_saq->ajouter_liste();
		echo '<script>alert("La liste d\'achats a été créée.")</script>';
		header('Location: ' . site_url( 'cellier&action=voir&id_cellier=1') );
	}

}
