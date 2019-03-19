<?php
	class Controleur_bouteille extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params["action"])
			{
				case "index":
					$modeleBouteille = $this->getDAO('Bouteille');
					
					$donnees["bouteilles"] = $modeleBouteille->obtenir_tous();
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;
				default :
					trigger_error("Action invalide.");
			}
		}
	}
