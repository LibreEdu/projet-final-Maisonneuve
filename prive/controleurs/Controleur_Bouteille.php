<?php

/**
 * Gestion des bouteilles des usagers.
 *
 * @package  Vino
 * @author   José Ignacio Delgado
 * @version  1.0
 */
final class Controleur_Bouteille extends Controleur
{
	/**
	 * @var object $modele_bouteille Le modèle Modele_Bouteille.
	 */
	private $modele_bouteille;


	/**
	 * @var object $modele_cellier Le modèle Modele_Cellier.
	 */
	private $modele_cellier;


	/**
	 * @var object $modele_type Le modèle Modele_Type.
	 */
	private $modele_type;


	/**
	 * Initialise les modèles.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		$this->modele_bouteille = $this->modele('Modele_bouteille');
		$this->modele_cellier = $this->modele('Modele_cellier');
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
		// On vérifie que l’usagé est bien connecté
		if ( ! isset($_SESSION['id_usager']) )
		{
			header('Location: ' . base_url() );
		}

		switch($params['action'])
		{
			case 'modifier-form':
				$this->modifier_form();
				break;

			case 'modifier':
				$this->modifier();
				break;

			case 'ajouter':
				$this->ajouter();
				break;

			case 'boire-js':
				$this->boire_js();
				break;
				
			case 'ajouter-js':
				$this->ajouter_js();
				break;
				
			case 'ajouter-form':
				$this->ajouter_form();
				break;

			case 'saisie-semi-automatique':
				$this->saisie_semi_automatique();
				break;

			case 'liste_form':
				$this->liste_form();
				break;

			case 'supprimer_bouteille':
				$this->supprimer_bouteille();
				break;

			default :
				trigger_error('Action invalide.');
		}
	}


	/**
	 * Affiche le formulaire de modification d’une bouteille.
	 * 
	 * @return void
	 */
	private function modifier_form()
	{
		$idBouteille = $this->modele_bouteille->appartient($_GET['id'],$_SESSION['id_usager']);

		if ($idBouteille == null) {
			header('Location: ' . site_url('login&action=logout') );
		}

		$donnees['id_cellier'] = $_GET['id_cellier'];
		$donnees['bouteille'] = $this->modele_bouteille->obtenir_par_id($_GET['id']);
		$donnees['types'] = $this->modele_type->obtenir_tous();
		$donnees['celliers'] = $this->modele_cellier->obtenir_par_usager($_SESSION['id_usager']);

		// Titre à afficher dans le formulaire
		$donnees['titre'] = 'Modifier bouteille';

		// Action du bouton input du formulaire
		$donnees['actionBouton'] = 'modifier';

		// Value du bouton input du formulaire
		$donnees['titreBouton'] = 'Modifier la bouteille';

		// Classe du bouton input du formulaire
		$donnees['classeBouton'] = 'mdl-button mdl-js-button mdl-button--raised';

		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('bouteille/formulaire', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}


	/**
	 * Modifie une bouteille dans la table vino_bouteille.
	 * 
	 * @return void
	 */
	private function modifier()
	{
		$_POST['date_achat'] = ($_POST['date_achat'] == '') ? null : $_POST['date_achat'];
		$_POST['boire_avant'] = ($_POST['boire_avant'] == '') ? null : $_POST['boire_avant'];
		$_POST['millesime'] = ($_POST['millesime'] == '') ? null : $_POST['millesime'];

		$this->modele_bouteille->modifier();
		header('Location: ' . site_url( 'cellier&action=voir&id_cellier=' . $_POST['id_cellier']) );
	}


	/**
	 * Ajoute une bouteille dans la table vino_bouteille 
	 * 
	 * @return void
	 */
	private function ajouter()
	{
		$_POST['date_achat'] = ($_POST['date_achat'] == '') ? null : $_POST['date_achat'];
		$_POST['boire_avant'] = ($_POST['boire_avant'] == '') ? null : $_POST['boire_avant'];
		$_POST['millesime'] = ($_POST['millesime'] == '') ? null : $_POST['millesime'];

		$this->modele_bouteille->ajouter();
		header('Location: ' . site_url( 'cellier&action=voir&id_cellier=' . $_POST['id_cellier']) );
	}


	/**
	 * Diminue la quantité de bouteilles de 1.
	 * 
	 * @return void
	 */
	private function boire_js()
	{
		$body = json_decode(file_get_contents('php://input'));
		$this->modele_bouteille->modifier_quantite($body->id,-1);
		$resultat = $this->modele_bouteille->recuperer_quantite($body->id);	
		echo json_encode($resultat);
	}

	/**
	 * Augmente la quantité de bouteilles de 1.
	 * 
	 * @return void
	 */
	private function ajouter_js()
	{
		$body = json_decode(file_get_contents('php://input'));
		$this->modele_bouteille->modifier_quantite($body->id, 1);
		$resultat = $this->modele_bouteille->recuperer_quantite($body->id);
		echo json_encode($resultat);
	}


	/**
	 * Ajoute une bouteille dans la table vino_bouteille.
	 * 
	 * @return void
	 */
	private function ajouter_form()
	{
		$donnees['id_cellier'] = $_GET['id_cellier'];
		$donnees['types'] = $this->modele_type->obtenir_tous();
		$donnees['celliers'] = $this->modele_cellier->obtenir_par_usager($_SESSION['id_usager']);
		// Titre à afficher dans le formulaire
		$donnees['titre'] = 'Ajouter Bouteille';
		// Action du bouton input du formulaire
		$donnees['actionBouton'] = 'ajouter';
		// Value du bouton input du formulaire
		$donnees['titreBouton'] = 'Ajouter la bouteille';
		// Classe du bouton input du formulaire
		$donnees['classeBouton'] = 'mdl-button mdl-js-button mdl-button--raised mdl-button--colored';
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('bouteille/formulaire', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}


	/**
	 * Recherche une bouteille dans la table vino_bouteille_saq par nom saisi dans le formulaire d'ajout
	 * 
	 * @return void
	 */
	private function saisie_semi_automatique()
	{
		$body = json_decode(file_get_contents('php://input'));
		$listeBouteilles = $this->modele_bouteille_saq->autocomplete($body->nom);
		echo json_encode($listeBouteilles);
	}


	/**
	 * Supprime une bouteille par id bouteille dans la table vino_bouteille
	 * 
	 * @return void
	 */
	private function supprimer_bouteille()
	{
		$body = json_decode(file_get_contents('php://input'));
		$resultat = $this->modele_bouteille->supprimerBouteilleParIdBouteille($body->id_bouteille_supprimer);
		echo json_encode(true);
	}
}
