<?php
class Bouteille extends CI_Controller
{
	public function index()
	{
		$modeleBouteille = $this->load->model('Modele_Bouteille');
		$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();
		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('cellier/cellier', $donnees);
		$this->load->view('modeles/bas-de-page');
	}

	public function visiterCellier()
	{
		// Recuperation de nom de cellier pour l'afficher en haut de la page
		$modeleCellier = $this->load->model('Modele_Cellier');
		$idCellier = $modeleCellier->verifParUsager($_GET['id'],$_SESSION["idUsager"]);

		if ($idCellier == null) {
			header('Location: ' . site_url('login/logout'));
		}

		// Recuperation de tous les bouteilles qui appartient a un cellier specifique
		$modeleBouteille = $this->load->model('Modele_Bouteille');
		$resultat = $modeleCellier->obtenir_par_id_cellier($_GET['id']);
		$donnees['bouteilles'] = $modeleBouteille->lireAvecType($_GET['id']);
		$monCellier = $resultat[0];
		$donnees['cellier'] = $monCellier->nom;


		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('cellier/cellier', $donnees);
		$this->load->view('modeles/bas-de-page');
	}

	public function modifier_form()
	{
		$modeleBouteille = $this->load->model('Modele_Bouteille');
		$idBouteille = $modeleBouteille->verifParUsager($_GET['id'],$_SESSION["idUsager"]);

		if ($idBouteille == null) {
			header('Location: ' . site_url('login/logout'));
		}
		
		$donnees['bouteille'] = $modeleBouteille->obtenir_par_id($_GET['id']);
		$modeleType = $this->load->model('Modele_Type');
		$donnees['types'] = $modeleType->obtenir_tous();
		$modeleCellier = $this->load->model('Modele_Cellier');
		$donnees['celliers'] = $modeleCellier->obtenir_par_id($_SESSION["idUsager"]);
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
		$modeleBouteille = $this->load->model('Modele_Bouteille');
		$modeleBouteille->modifierBouteille();
		$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();
		echo '<script>alert("La bouteille a été modifiée.")</script>';
		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('cellier/cellier', $donnees);
		$this->load->view('modeles/bas-de-page');
	}

	public function ajouter()
	{
		// Recuperation de tous les bouteilles qui appartient a un cellier specifique
		$modeleBouteille = $this->load->model('Modele_Bouteille');
		$resultat = $modeleBouteille->obtenir_par_id_cellier($_POST['id_cellier']);
		$donnees['bouteilles'] = $modeleBouteille->lireAvecType($_POST['type']);
		$monCellier = $resultat[0];
		$donnees['cellier'] = $monCellier->nom;
		$modeleBouteille = $this->load->model('Modele_Bouteille');
		$modeleBouteille->ajouterUneBouteille();
		$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();
		echo '<script>alert("La bouteille a été ajoutée.")</script>';
		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('cellier/cellier', $donnees);
		$this->load->view('modeles/bas-de-page');
	}

	public function boire_js()
	{
		$body = json_decode(file_get_contents('php://input'));
		$modeleBouteille = $this->load->model('Modele_Bouteille');
		$modeleBouteille->modifierQuantiteBouteilleCellier($body->id,-1);
		$resultat = $modeleBouteille->recupererQuantiteBouteilleCellier($body->id);	
		echo json_encode($resultat);
	}

	public function ajouter_js()
	{
		$body = json_decode(file_get_contents('php://input'));
		$modeleBouteille = $this->load->model('Modele_Bouteille');
		$modeleBouteille->modifierQuantiteBouteilleCellier($body->id, 1);
		$resultat = $modeleBouteille->recupererQuantiteBouteilleCellier($body->id);
		// var_dump($resultat);
		echo json_encode($resultat);
	}

	public function ajouter_form()
	{
		$modeleType = $this->load->model('Modele_Type');
		$donnees['types'] = $modeleType->obtenir_tous();
		$modeleCellier = $this->load->model('Modele_Cellier');
		$donnees['celliers'] = $modeleCellier->obtenir_par_id($_SESSION["idUsager"]);
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
		$modeleBouteille = $this->load->model('Modele_Bouteille');
		$listeBouteilles = $modeleBouteille->autocomplete($body->nom);
		echo json_encode($listeBouteilles);
	}
}
