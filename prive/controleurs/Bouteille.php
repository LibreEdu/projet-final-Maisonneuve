<?php
class Bouteille extends Controleur
{
	protected $modele_bouteille;
	protected $modele_cellier;
	protected $modele_type;
	
	public function __construct()
	{
		$this->modele_bouteille = $this->modele('modele_bouteille');
		$this->modele_cellier = $this->modele('modele_cellier');
		$this->modele_type = $this->modele('modele_type');
	}

	public function traite(array $params)
	{
		// On vérifie que l’usagé est bien connecté
		if ( ! isset($_SESSION["idUsager"]) )
		{
			header('Location: ' . base_url() );
		}

		switch($params['action'])
		{
			case 'index':
				$this->index();
				break;

			case 'visiterCellier':
				$this->visiterCellier();
				break;

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

			default :
				trigger_error('Action invalide.');
		}
	}

	public function index()
	{
		$donnees['bouteilles'] = $this->modele_bouteille->obtenir_tous();
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('cellier/cellier', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}

	public function visiterCellier()
	{
		// Recuperation de nom de cellier pour l'afficher en haut de la page

		$idCellier = $this->modele_cellier->verifParUsager($_GET['id'],$_SESSION["idUsager"]);

		if ($idCellier == null) {
			header('Location: ' . site_url('login&action=logout') );
		}

		// Recuperation de tous les bouteilles qui appartient a un cellier specifique
		$resultat = $this->modele_cellier->obtenir_par_id_cellier($_GET['id']);
		$donnees['bouteilles'] = $this->modele_bouteille->lireAvecType($_GET['id']);
		$monCellier = $resultat[0];
		$donnees['cellier'] = $monCellier->nom;

		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('cellier/cellier', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}

	public function modifier_form()
	{
		$idBouteille = $this->modele_bouteille->verifParUsager($_GET['id'],$_SESSION["idUsager"]);

		if ($idBouteille == null) {
			header('Location: ' .  site_url('login&action=logout') );
		}
		
		$donnees['bouteille'] = $this->modele_bouteille->obtenir_par_id($_GET['id']);
		$donnees['types'] = $this->modele_type->obtenir_tous();
		$donnees['celliers'] = $this->modele_cellier->obtenir_par_id($_SESSION["idUsager"]);
		$donnees['titre'] = 'Modifier Bouteille';
		$donnees['actionBouton'] = 'modifier';
		$donnees['titreBouton'] = 'Modifier la bouteille';
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('bouteille/formulaire', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}

	public function modifier()
	{
		$this->modele_bouteille->modifierBouteille();
		$donnees['bouteilles'] = $this->modele_bouteille->obtenir_tous();
		echo '<script>alert("La bouteille a été modifiée.")</script>';
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('cellier/cellier', $donnees);
		$this->afficheVue('modeles/bas-de-page');
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
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('cellier/cellier', $donnees);
		$this->afficheVue('modeles/bas-de-page');
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
		echo json_encode($resultat);
	}

	public function ajouter_form()
	{
		$donnees['types'] = $this->modele_type->obtenir_tous();
		$donnees['celliers'] = $this->modele_cellier->obtenir_par_id($_SESSION["idUsager"]);
		$donnees['titre'] = 'Ajouter Bouteille';
		$donnees['actionBouton'] = 'ajouter';
		$donnees['titreBouton'] = 'Ajouter la bouteille';
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('bouteille/formulaire', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}

	public function saisie_semi_automatique()
	{
		$body = json_decode(file_get_contents('php://input'));
		$listeBouteilles = $this->modele_bouteille->autocomplete($body->nom);
		echo json_encode($listeBouteilles);
	}
}
