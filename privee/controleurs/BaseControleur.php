<?php
	abstract class BaseControleur
	{
		//la fonction qui sera appelée par le routeur
		public abstract function traite(array $params);
		
		protected function afficheVue($nomVue, $data = null)
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
		
		protected function getDAO($nomModele)
		{
			$classe = "Modele_" . $nomModele;
			if(class_exists($classe))
			{
				
				//on fait une connexion à la BD
				$connexion = DBFactory::getDB(DBTYPE, DBNAME, HOST, USER, PWD);
				
				//on crée une instance de la classe Modele_$classe
				$objetModele = new $classe($connexion);
				
				
				if($objetModele instanceof BaseDAO)
				{
					return $objetModele;
				}
				else
					trigger_error("Modèle invalide.");
			}
			else {
				trigger_error("La classe $classe est invalide.");
			}
		}
	}

?>