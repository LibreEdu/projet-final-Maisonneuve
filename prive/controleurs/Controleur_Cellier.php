<?php

/**
 * Création, suppression et affichage du cellier.
 *
 * @package  Vino
 * @author   Fatemeh Homatash
 * @version  1.0
 */
final class Controleur_Cellier extends Controleur
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
			case 'index':
				$this->index();
				break;

			case 'voir':
				$this->voir();
				break;

			case 'ajouter-form':
				$this->ajouter_form();
				break;

			case 'ajouter':
				$this->ajouter();
				break;

			case 'supprimer':
				$this->supprimerCellier();
				break;

			case 'pageRecherche':
				$this->pageRecherche();
				break;

			case 'recherche':
				$this->recherche();
				break;

			default :
				trigger_error('Action invalide.');
		}
	}


	/**
	 * Affiche la liste des celliers
	 * 
	 * @return void
	 */
	private function index()
	{
		$donnees['celliers'] = $this->modele_cellier->obtenir_par_usager($_SESSION['id_usager']);
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('cellier/liste', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}


	/**
	 * Récupère toutes les bouteilles qui appartiennent à un cellier.
	 * 
	 * @return void
	 */
	private function voir()
	{
		$idCellier = $this->modele_cellier->verif_usager($_GET['id_cellier'],$_SESSION['id_usager']);
		if ($idCellier == null) {
			header('Location: ' . site_url('login&action=logout') );
		}
		$resultat = $this->modele_cellier->obtenir_par_id($_GET['id_cellier']);
		$donnees['bouteilles'] = $this->modele_bouteille->bouteilles_cellier($_GET['id_cellier']);

		// S’il n’y a aucune bouteille dans le cellier, il dirige directement vers le formulaire ajout bouteille
		if ($donnees['bouteilles']==null) {
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
		// S’il existe déjà des bouteilles dans le cellier, affiche la liste de tous les bouteilles existant
		else{
			$this->afficheVue('modeles/en-tete');
			$this->afficheVue('modeles/menu-usager');
			$this->afficheVue('cellier/cellier', $donnees);
			$this->afficheVue('modeles/bas-de-page');
		}
	}


	/**
	 * Affiche le formulaire d’ajout de cellier.
	 * 
	 * @return void
	 */
	private function ajouter_form()
	{
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('cellier/ajouter');
		$this->afficheVue('modeles/bas-de-page');
	}


	/**
	 * Ajoute un cellier.
	 * 
	 * @return void
	 */
	private function ajouter()
	{
		$this->modele_cellier->ajouter($_SESSION['id_usager']);
		$donnees['celliers'] = $this->modele_cellier->obtenir_par_usager($_SESSION['id_usager']);
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('cellier/liste', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}


	/**
	 * Supprime un cellier.
	 * 
	 * @return void
	 */
	private function supprimerCellier()
	{
		$body = json_decode(file_get_contents('php://input'));
		$this->modele_bouteille->supprimerBouteille($body->id_cellier);
		$this->modele_cellier->supprimerCellier($body->id_cellier);
		echo json_encode(true);
	}	


	/**
	 * Affiche le résultat de la page de recherche
	 * 
	 * @return void
	 */
	private function pageRecherche()
	{
		$donnees['id-cellier'] = $_GET['id_cellier'];
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('cellier/recherche', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}

	/**
	 * Effectue une recherche dans le cellier
	 * 
	 * @return void
	 */
	private function recherche()
	{
		$body = json_decode(file_get_contents('php://input'));
		$listeBouteilles = $this->modele_bouteille->recherche($body->id_cellier, $body->recherchePar, $body->valeur, $body->operation);
		echo json_encode($listeBouteilles);
	}
}
