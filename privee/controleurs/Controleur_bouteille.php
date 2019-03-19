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

				case "boireBouteilleCellier":
					
					$body = json_decode(file_get_contents('php://input'));
					$modeleBouteille = $this->getDAO('Bouteille');
					
					$modeleBouteille->modifierQuantiteBouteilleCellier($body->id,-1);
					$resultat = $modeleBouteille->recupererQuantiteBouteilleCellier($body->id);	

					echo json_encode($resultat);					
					break;

				case "ajouterBouteilleCellier":
					
					$body = json_decode(file_get_contents('php://input'));
					$modeleBouteille = $this->getDAO('Bouteille');
					
					$modeleBouteille->modifierQuantiteBouteilleCellier($body->id, 1);
					$resultat = $modeleBouteille->recupererQuantiteBouteilleCellier($body->id);	

					echo json_encode($resultat);					
					break;
				default :
					trigger_error("Action invalide.");
			}
		}
	}
