<?php

/**
 * Gestion des bouteilles des usagers.
 *
 * @package  Vino
 * @author   José Ignacio Delgado
 * @version  1.0
 */
 class Controleur_Bouteille extends Controleur
{
	/**
	 * @var object $modele_bouteille Le modèle Modele_Bouteille.
	 * @var object $modele_cellier Le modèle Modele_Cellier.
	 * @var object $modele_type Le modèle Modele_Type.
	 */
	private $modele_bouteille;
	private $modele_cellier;
	private $modele_type;
	
	// Constructeur des modèles
	public function __construct()
	{
		$this->modele_bouteille = $this->modele('modele_bouteille');
		$this->modele_cellier = $this->modele('modele_cellier');
		$this->modele_type = $this->modele('modele_type');
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
	 * Modifier une bouteille dans la table vino_bouteille 
	 * Renvoyer au formulaire de modification
	 * @param integer $_SESSION['id_usager'] L'id de l'usager connecté
	 * @param integer $idBouteille L'id de la bouteille
	 * @return array tous les données de la bouteille trouvée dans le catalogue
	 * @return array tous les données des celliers trouvés dans le catalogue
	 * @return array tous les données des types de vin trouvés dans le catalogue
	 */
	public function modifier_form()
	{
		$idBouteille = $this->modele_bouteille->appartient($_GET['id'],$_SESSION['id_usager']);

		if ($idBouteille == null) {
			header('Location: ' . site_url('login&action=logout') );
		}
		
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
	 * Modifier une bouteille dans la table vino_bouteille 
	 * @param integer $_POST['id_cellier'] L'id cu cellier
	 */
	public function modifier()
	{
		$this->modele_bouteille->modifier();
		echo '<script>alert("La bouteille a été modifiée.")</script>';
		header('Location: ' . site_url( 'cellier&action=voir&id_cellier=' . $_POST['id_cellier']) );
	}

	/**
	 * Ajouter une bouteille dans la table vino_bouteille 
	 * Renvoyer à la page d'affichage des celliers
	 * @param integer $_POST['id_cellier'] L'id du cellier
	 */
	public function ajouter()
	{
		$this->modele_bouteille->ajouter();
		echo '<script>alert("La bouteille a été ajoutée.")</script>';
		header('Location: ' . site_url( 'cellier&action=voir&id_cellier=' . $_POST['id_cellier']) );
	}

	public function boire_js()
	{
		$body = json_decode(file_get_contents('php://input'));
		$this->modele_bouteille->modifier_quantite($body->id,-1);
		$resultat = $this->modele_bouteille->recuperer_quantite($body->id);	
		echo json_encode($resultat);
	}

	public function ajouter_js()
	{
		$body = json_decode(file_get_contents('php://input'));
		$this->modele_bouteille->modifier_quantite($body->id, 1);
		$resultat = $this->modele_bouteille->recuperer_quantite($body->id);
		echo json_encode($resultat);
	}

	/**
	 * Ajouter une bouteille dans la table vino_bouteille 
	 * Renvoyer au formulaire d'ajout
	 * @param integer $_SESSION['id_usager'] L'id de l'usager connecté
	 * @return array tous les données des celliers trouvés dans le catalogue
	 * @return array tous les données des types de vin trouvés dans le catalogue
	 */
	public function ajouter_form()
	{
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
	 * Rechercher une bouteille dans la table vino_bouteille_saq par nom saisi dans le formulaire d'ajout
	 * @param $body->nom Le nom à rechercher
	 * @return array tous les données de la bouteille trouvée dans le catalogue
	 */
	public function saisie_semi_automatique()
	{
		$body = json_decode(file_get_contents('php://input'));
		$listeBouteilles = $this->modele_bouteille_saq->autocomplete($body->nom);
		echo json_encode($listeBouteilles);
	}

	/**
	 * Supprime une bouteille par id bouteille dans la table vino_bouteille
	 * @param integer $body->id_bouteille_supprimer L'id de la bouteille à supprimer
	 * 
	 * À VÉRIFIER, CE QUE LA FONCTION RETOURNE
	 * @return boolean Indique si la requête a correctement fonctionné.
	 */
	public function supprimer_bouteille()
	{
		$body = json_decode(file_get_contents('php://input'));
		$resultat = $this->modele_bouteille->supprimerBouteilleParIdBouteille($body->id_bouteille_supprimer);
		echo json_encode(true);
	}
}
