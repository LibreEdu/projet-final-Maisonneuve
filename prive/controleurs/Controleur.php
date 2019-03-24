<?php
abstract class Controleur
{
	protected $modele_bouteille;
	protected $modele_cellier;
	protected $modele_type;
	protected $modele_usager;
	
	public function __construct()
	{
		$this->modele_bouteille = $this->modele('modele_bouteille');
		$this->modele_cellier = $this->modele('modele_cellier');
		$this->modele_type = $this->modele('modele_type');
		$this->modele_usager = $this->modele('modele_usager');
	}

	// La fonction qui sera appelée par le routeur
	public abstract function traite(array $params);
	
	protected function afficheVue($nomVue, $donnees = null)
	{
		$cheminVue = RACINE . "vues/" . $nomVue . ".php";
		
		if(file_exists($cheminVue))
		{
			include_once($cheminVue);
		}
		else
		{
			trigger_error("Erreur 404! La vue $nomVue n'existe pas.");
		}
	}

	protected function modele($nomModele)
	{
		if(class_exists($nomModele))
		{
			// On fait une connexion à la BD
			$connexion = DBFactory::getDB(DBTYPE, HOST, DBNAME, CHARSET, USER, PWD);
			
			// On crée une instance de la classe Modele_$classe
			$objetModele = new $nomModele($connexion);

			if($objetModele instanceof Modele)
			{
				return $objetModele;
			}
			else
			{
				trigger_error("Modèle invalide.");
			}
		}
		else
		{
			trigger_error("Le modèle $nomModele est invalide.");
		}
	}
}
