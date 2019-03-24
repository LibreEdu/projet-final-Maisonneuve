<?php
class Cellier extends CI_Controller
{
	public function index()
	{
		// Récupère d’usager qui est connecté
		$modeleUsager = $this->load->model('Usager');		
		$user = $modeleUsager->obtenirUsager($_SESSION["UserID"]);
		$_SESSION['id_usager'] = $user->id_usager;
		
		// Affiche la liste des celliers de l’usager connecté
		$modeleCellier = $this->load->model('Cellier');
		$donnees['celliers'] = $modeleCellier->obtenir_par_id($_SESSION['id_usager']);
		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('cellier/liste', $donnees);
		$this->load->view('modeles/bas-de-page');
	}
	
	public function ajouter_form()
	{
		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('cellier/ajouter');
		$this->load->view('modeles/bas-de-page');
	}
	
	public function ajouter()
	{
		$modeleCellier = $this->load->model('Cellier');
		$modeleCellier->ajoutCellier($_SESSION['id_usager']);
		$donnees['celliers'] = $modeleCellier->obtenir_par_id($_SESSION['id_usager']);
		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('cellier/liste', $donnees);
		$this->load->view('modeles/bas-de-page');
	}
	
	public function supprimer()
	{
		$body = json_decode(file_get_contents('php://input'));
		$modeleCellier = $this->load->model('Cellier');
		$modeleCellier->supprimer_par_id($body->id);
		echo json_encode(true);
	}
}
