<?php
	class Controleur_cellier extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params["action"])
			{
				case "index":
					$modeleCellier = $this->getDAO('Cellier');					
					$donnees["celliers"] = $modeleCellier->obtenir_par_id(1);					
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('listesCelliers', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				/*case "modifierBouteille":					
					$modeleCellier = $this->getDAO('Bouteille');
					$donnees["bouteille"] = $modeleCellier->obtenir_par_id($_GET["id"]);
					$modeleType = $this->getDAO('Type');
					$donnees["types"] = $modeleType->obtenir_tous();
					$modeleCellier = $this->getDAO('Cellier');
					$donnees["celliers"] = $modeleCellier->obtenir_tous();
					$donnees["titre"] = "Modifier Bouteille";
					$donnees["actionBouton"] = "modifier";
					$donnees["titreBouton"] = "Modifier la bouteille";
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modifier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case "modifier":
					$modeleCellier = $this->getDAO('Bouteille');
					$modeleCellier->modifierBouteille();
					$donnees["celliers"] = $modeleCellier->obtenir_tous();
					echo "<script>alert(\"La bouteille a été modifiée.\")</script>";					
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case "ajouter":
					$modeleCellier = $this->getDAO('Bouteille');
					$modeleCellier->ajouterUneBouteille();
					$donnees["celliers"] = $modeleCellier->obtenir_tous();
					echo "<script>alert(\"La bouteille a été ajoutée.\")</script>";					
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case "boireBouteilleCellier":					
					$body = json_decode(file_get_contents('php://input'));
					$modeleCellier = $this->getDAO('Bouteille');				
					$modeleCellier->modifierQuantiteBouteilleCellier($body->id,-1);
					$resultat = $modeleCellier->recupererQuantiteBouteilleCellier($body->id);	
					echo json_encode($resultat);					
					break;

				case "ajouterBouteilleCellier":					
					$body = json_decode(file_get_contents('php://input'));
					$modeleCellier = $this->getDAO('Bouteille');					
					$modeleCellier->modifierQuantiteBouteilleCellier($body->id, 1);
					$resultat = $modeleCellier->recupererQuantiteBouteilleCellier($body->id);	
					echo json_encode($resultat);					
					break;

				case "ajouterNouvelleBouteilleCellier":					
					$modeleType = $this->getDAO('Type');
					$donnees["types"] = $modeleType->obtenir_tous();
					$modeleCellier = $this->getDAO('Cellier');
					$donnees["celliers"] = $modeleCellier->obtenir_tous();
					$donnees["titre"] = "Ajouter Bouteille";
					$donnees["actionBouton"] = "ajouter";
					$donnees["titreBouton"] = "Ajouter la bouteille";
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modifier', $donnees);
					$this->afficheVue('modeles/bas-de-page');					
					break;

				case "autocompleteBouteille":
					$body = json_decode(file_get_contents('php://input'));
					$modeleCellier = $this->getDAO('Bouteille');
					$listeBouteilles = $modeleCellier->autocomplete($body->nom);
					echo json_encode($listeBouteilles);					
					break;*/

				default :
					trigger_error("Action invalide.");
			}
		}
	}
