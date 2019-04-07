<?php

/**
 * Gestion des liste d'achat.
 *
 * @package  Vino
 * @author   José Ignacio Delgado
 * @version  1.0
 */
final class Controleur_Liste_Achat extends Controleur
{
	/**
	 * @var object $modele_liste Le modèle Modele_Liste.
	 */
	private $modele_liste;


	/**
	 * @var object $modele_affichage Le modèle Modele_Affichage.
	 */
	private $modele_affichage;


	/**
	 * Initialise les modèles.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		$this->modele_liste = $this->modele('modele_liste');
		$this->modele_affichage = $this->modele('modele_affichage');
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

	/**
	 * Recherche une bouteille dans la table vino_bouteille_saq par nom saisi dans le formulaire de création d’une liste d’achat
	 * 
	 * @return void
	 */
	private function saisie_semi_automatique()
	{
		$body = json_decode(file_get_contents('php://input'));
		$listeBouteilles = $this->modele_liste->autocomplete($body->nom);
		echo json_encode($listeBouteilles);
	}

	/**
	 * Renvoie au formulaire de création d’une liste d’achat
	 * 
	 * @return void
	 */
	private function liste_form()
	{
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('bouteille/formulaire.1');
		$this->afficheVue('modeles/bas-de-page');
	}

	/**
	 * Crée une liste d’achat dans la table vino_liste_achat et des bouteilles par id liste achat dans la table vino_liste_affichage 
	 * 
	 * @return void
	 */
	private function ajouter_liste()
	{
		// Ajoute de la liste dans la table vino_liste_achat et les id des bouteilles dans la table vino_liste_affichage
		// par rapport à l’id de la liste d’achat
		$this->modele_liste->ajouter_liste();

		// Récupère les noms des listes d’achat
		$donnees['noms'] = $this->modele_liste->obtenir_tous();
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');

		// Renvoi à la page d’affichage des listes d’achat
		$this->afficheVue('bouteille/achat', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}


	/**
	 * Obtient les détails des bouteilles par id liste achat dans la table vino_bouteille_saq 
	 * 
	 * @return void
	 */
	private function details_liste_achat()
	{
		// Envoi des bouteilles de la table vino_bouteille_saq para rapport à l'id de la liste d'affichage
		$donnees['listes'] = $this->modele_liste->obtenir_liste($_SESSION['id_usager'], $_GET['nom']);
		// Récupérer les noms des listes d'achat
		$donnees['noms'] = $this->modele_liste->obtenir_tous();
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		// Renvoi à la page d'affichage des bouteilles de la liste d'achat
		$this->afficheVue('bouteille/details_liste_achat', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}


	/**
	 * Va à la page d’affichage des bouteilles d’une liste d’achat
	 * 
	 * @return void
	 */
	private function listes_achat()
	{
		// Récupérer les noms des listes d'achat
		$donnees['noms'] = $this->modele_liste->obtenir_tous();
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('bouteille/achat', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}


	/**
	 * Supprime liste d’achat et bouteilles par id liste achat dans les tables vino_liste_achat et vino_liste_affichage
	 * 
	 * @return void
	 */
	private function supprimer_liste_achat()
	{
		// Supprime la liste d'achat de la table vino_liste_achat, dont l’id est envoyé en paramètre
		$this->modele_liste->supprimerListe($_GET['id_liste_achat']);

		// Supprime les bouteilles de la table vino_liste_affichage, dont l’id de la liste d’achat est envoyé en paramètre
		$this->modele_affichage->supprimerBouteille($_GET['id_liste_achat']);

		// Récupère les noms des listes d'achat
		$donnees['noms'] = $this->modele_liste->obtenir_tous();

		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('bouteille/achat', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}
}
