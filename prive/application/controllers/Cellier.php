<?php
class Cellier extends CI_Controller
{
	public function index()
	{
		// Récupère d’usager qui est connecté
		$modeleUsager = $this->getDAO('Usager');		
		$user = $modeleUsager->obtenirUsager($_SESSION["UserID"]);
		$_SESSION['id_usager'] = $user->id_usager;
		
		// Affiche la liste des celliers de l’usager connecté
		$modeleCellier = $this->getDAO('Cellier');
		$donnees['celliers'] = $modeleCellier->obtenir_par_id($_SESSION['id_usager']);
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('cellier/liste', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}
	
	public function ajouter_form()
	{
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('cellier/ajouter');
		$this->afficheVue('modeles/bas-de-page');
	}
	
	public function ajouter()
	{
		$modeleCellier = $this->getDAO('Cellier');
		$modeleCellier->ajoutCellier($_SESSION['id_usager']);
		$donnees['celliers'] = $modeleCellier->obtenir_par_id($_SESSION['id_usager']);
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('cellier/liste', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}
	
	public function supprimer()
	{
		$body = json_decode(file_get_contents('php://input'));
		$modeleCellier = $this->getDAO('Cellier');
		$modeleCellier->supprimer_par_id($body->id);
		echo json_encode(true);
	}
}
