<?php
class Bouteille extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('modele_bouteille');
		$this->load->model('modele_cellier');
		$this->load->model('modele_type');
	}

	public function index()
	{
		
		$donnees['bouteilles'] = $this->modele_bouteille->obtenir_tous();
		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('cellier/cellier', $donnees);
		$this->load->view('modeles/bas-de-page');
	}

	public function visiterCellier()
	{
		// Recuperation de nom de cellier pour l'afficher en haut de la page
		
		$idCellier = $this->modele_cellier->verifParUsager($_GET['id'],$_SESSION["idUsager"]);

		if ($idCellier == null) {
			header('Location: ' . site_url('login/logout'));
		}

		// Recuperation de tous les bouteilles qui appartient a un cellier specifique
		$resultat = $this->modele_cellier->obtenir_par_id_cellier($_GET['id']);
		$donnees['bouteilles'] = $this->modele_bouteille->lireAvecType($_GET['id']);
		$monCellier = $resultat[0];
		$donnees['cellier'] = $monCellier->nom;


		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('cellier/cellier', $donnees);
		$this->load->view('modeles/bas-de-page');
	}

	public function modifier_form()
	{
		$idBouteille = $this->modele_bouteille->verifParUsager($_GET['id'],$_SESSION["idUsager"]);

		if ($idBouteille == null) {
			header('Location: ' . site_url('login/logout'));
		}
		
		$donnees['bouteille'] = $this->modele_bouteille->obtenir_par_id($_GET['id']);
		$donnees['types'] = $this->modele_type->obtenir_tous();
		$donnees['celliers'] = $this->modele_cellier->obtenir_par_id($_SESSION["idUsager"]);
		$donnees['titre'] = 'Modifier Bouteille';
		$donnees['actionBouton'] = 'modifier';
		$donnees['titreBouton'] = 'Modifier la bouteille';
		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('bouteille/formulaire', $donnees);
		$this->load->view('modeles/bas-de-page');
	}

	public function modifier()
	{
		$this->modele_bouteille->modifierBouteille();
		$donnees['bouteilles'] = $this->modele_bouteille->obtenir_tous();
		echo '<script>alert("La bouteille a été modifiée.")</script>';
		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('cellier/cellier', $donnees);
		$this->load->view('modeles/bas-de-page');
	}

	public function ajouter()
	{
		// Recuperation de tous les bouteilles qui appartient a un cellier specifique
		$resultat = $this->modele_bouteille->obtenir_par_id_cellier($_POST['id_cellier']);
		$donnees['bouteilles'] = $this->modele_bouteille->lireAvecType($_POST['type']);
		$monCellier = $resultat[0];
		$donnees['cellier'] = $monCellier->nom;
		$this->modele_bouteille->ajouterUneBouteille();
		$donnees['bouteilles'] = $this->modele_bouteille->obtenir_tous();
		echo '<script>alert("La bouteille a été ajoutée.")</script>';
		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('cellier/cellier', $donnees);
		$this->load->view('modeles/bas-de-page');
	}

	public function boire_js()
	{
		$body = json_decode(file_get_contents('php://input'));
		$this->modele_bouteille->modifierQuantiteBouteilleCellier($body->id,-1);
		$resultat = $this->modele_bouteille->recupererQuantiteBouteilleCellier($body->id);	
		echo json_encode($resultat);
	}

	public function ajouter_js()
	{
		$body = json_decode(file_get_contents('php://input'));
		$this->modele_bouteille->modifierQuantiteBouteilleCellier($body->id, 1);
		$resultat = $this->modele_bouteille->recupererQuantiteBouteilleCellier($body->id);
		// var_dump($resultat);
		echo json_encode($resultat);
	}

	public function ajouter_form()
	{
		$donnees['types'] = $this->modele_type->obtenir_tous();
		$donnees['celliers'] = $this->modele_cellier->obtenir_par_id($_SESSION["idUsager"]);
		$donnees['titre'] = 'Ajouter Bouteille';
		$donnees['actionBouton'] = 'ajouter';
		$donnees['titreBouton'] = 'Ajouter la bouteille';
		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('bouteille/formulaire', $donnees);
		$this->load->view('modeles/bas-de-page');
	}

	public function saisie_semi_automatique()
	{
		$body = json_decode(file_get_contents('php://input'));
		$listeBouteilles = $this->modele_bouteille->autocomplete($body->nom);
		echo json_encode($listeBouteilles);
	}
}
