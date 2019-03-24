<?php
class Cellier extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('modele_usager');
		$this->load->model('modele_cellier');
	}
	
	public function index()
	{
		// Récupère d’usager qui est connecté		
		$user = $this->modele_usager->obtenirUsager($_SESSION["UserID"]);
		$_SESSION['id_usager'] = $user->id_usager;
		
		// Affiche la liste des celliers de l’usager connecté
		$donnees['celliers'] = $this->modele_cellier->obtenir_par_id($_SESSION['id_usager']);
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
		$this->modele_cellier->ajoutCellier($_SESSION['id_usager']);
		$donnees['celliers'] = $this->modele_cellier->obtenir_par_id($_SESSION['id_usager']);
		$this->load->view('modeles/en-tete');
		$this->load->view('modeles/menu-usager');
		$this->load->view('cellier/liste', $donnees);
		$this->load->view('modeles/bas-de-page');
	}
	
	public function supprimer()
	{
		$body = json_decode(file_get_contents('php://input'));
		this->modele_cellier->supprimer_par_id($body->id);
		echo json_encode(true);
	}
}
