<?php

/**
 * Gestion des liste d'achat.
 *
 * @package  Vino
 * @author   José Ignacio Delgado
 * @version  1.0
 */
class Controleur_Liste_Achat extends Controleur
{
	/**
	 * @var object $modele_liste Le modèle Modele_Liste.
	 * @var object $modele_affichage Le modèle Modele_Affichage.
	 */
	private $modele_liste;
	private $modele_affichage;
	
	public function __construct()
	{
		$this->modele_liste = $this->modele('modele_liste');
		$this->modele_affichage = $this->modele('modele_affichage');
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
			case 'details_liste_achat':
				$this->details_liste_achat();
				break;
			case 'listes_achat':
				$this->listes_achat();
				break;
			case 'supprimer_liste_achat':
				$this->supprimer_liste_achat();
				break;
			default :
				trigger_error('Action invalide.');
		}
	}

	public function saisie_semi_automatique()
	{
		$body = json_decode(file_get_contents('php://input'));
		$listeBouteilles = $this->modele_liste->autocomplete($body->nom);
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
		$this->modele_liste->ajouter_liste();
		$donnees['noms'] = $this->modele_liste->obtenir_tous();
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('bouteille/achat', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}

	public function details_liste_achat()
	{
		$donnees['listes'] = $this->modele_liste->obtenir_liste($_SESSION['id_usager'], $_GET['nom']);
		$donnees['noms'] = $this->modele_liste->obtenir_tous();
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('bouteille/details_liste_achat', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}

	public function listes_achat()
	{
		$donnees['noms'] = $this->modele_liste->obtenir_tous();
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('bouteille/achat', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}
	public function supprimer_liste_achat()
	{
		$this->modele_liste->supprimerListe($_GET['id_liste_achat']);
		$this->modele_affichage->supprimerBouteille($_GET['id_liste_achat']);
		$donnees['noms'] = $this->modele_liste->obtenir_tous();
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('bouteille/achat', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}
}
