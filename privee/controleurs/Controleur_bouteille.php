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
				case "modifierBouteille":					
					$modeleBouteille = $this->getDAO('Bouteille');
					$donnees["bouteille"] = $modeleBouteille->obtenir_par_id($_GET["id"]);
					$modeleType = $this->getDAO('Type');
					$donnees["types"] = $modeleType->obtenir_tous();
					$donnees["titre"] = "Modifier Bouteille";
					$donnees["actionBouton"] = "modifier";
					$donnees["titreBouton"] = "Modifier la bouteille";
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modifier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;
				case "modifier":
					$this->modifierUneBouteille();
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
				case "ajouterNouvelleBouteilleCellier":					
					$modeleType = $this->getDAO('Type');
					$donnees["types"] = $modeleType->obtenir_tous();
					$donnees["titre"] = "Ajouter Bouteille";
					$donnees["actionBouton"] = "ajouter";
					$donnees["titreBouton"] = "Ajouter la bouteille";
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modifier', $donnees);
					$this->afficheVue('modeles/bas-de-page');					
					break;
				case "autocompleteBouteille":
					$body = json_decode(file_get_contents('php://input'));
					$modeleBouteille = $this->getDAO('Bouteille');
					$listeBouteilles = $modeleBouteille->autocomplete($body->nom);
					echo json_encode($listeBouteilles);					
					break;
				default :
					trigger_error("Action invalide.");
			}
		}
	}
