<?php
	class Controleur_bouteille extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params['action'])
			{
				case 'index':
					$modeleBouteille = $this->getDAO('Bouteille');
					
					$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();
					
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'modifierBouteille':
					$modeleBouteille = $this->getDAO('Bouteille');
					$donnees['bouteille'] = $modeleBouteille->obtenir_par_id($_GET['id']);
					$modeleType = $this->getDAO('Type');
					$donnees['types'] = $modeleType->obtenir_tous();
					$modeleCellier = $this->getDAO('Cellier');
					$donnees['celliers'] = $modeleCellier->obtenir_tous();
					$donnees['titre'] = 'Modifier Bouteille';
					$donnees['actionBouton'] = 'modifier';
					$donnees['titreBouton'] = 'Modifier la bouteille';
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modifier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'modifier':
					$modeleBouteille = $this->getDAO('Bouteille');
					$modeleBouteille->modifierBouteille();
					$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();
					echo '<script>alert("La bouteille a été modifiée.")</script>';
					
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'ajouter':
					$modeleBouteille = $this->getDAO('Bouteille');
					$modeleBouteille->ajouterUneBouteille();
					$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();
					echo '<script>alert("La bouteille a été ajoutée.")</script>';
					
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'boire':
					$body = json_decode(file_get_contents('php://input'));
					$modeleBouteille = $this->getDAO('Bouteille');
					
					$modeleBouteille->modifierQuantiteBouteilleCellier($body->id,-1);
					$resultat = $modeleBouteille->recupererQuantiteBouteilleCellier($body->id);	

					echo json_encode($resultat);
					break;
					
				case 'ajouterBouteilleCellier':
					
					$body = json_decode(file_get_contents('php://input'));
					$modeleBouteille = $this->getDAO('Bouteille');
					
					$modeleBouteille->modifierQuantiteBouteilleCellier($body->id, 1);
					$resultat = $modeleBouteille->recupererQuantiteBouteilleCellier($body->id);	

					echo json_encode($resultat);
					break;
					
				case 'ajouterBouteille':
					$modeleType = $this->getDAO('Type');
					$donnees['types'] = $modeleType->obtenir_tous();
					$modeleCellier = $this->getDAO('Cellier');
					$donnees['celliers'] = $modeleCellier->obtenir_tous();
					$donnees['titre'] = 'Ajouter Bouteille';
					$donnees['actionBouton'] = 'ajouter';
					$donnees['titreBouton'] = 'Ajouter la bouteille';
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modifier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'autocompleteBouteille':
					$body = json_decode(file_get_contents('php://input'));
					var_dump($body->nom);die;
					$modeleBouteille = $this->getDAO('Bouteille');
					
					$listeBouteilles = $modeleBouteille->autocomplete($body->nom);

					echo json_encode($listeBouteilles);
					break;

				case 'alex':
					$modeleBouteille = $this->getDAO('Bouteille');
					$listeBouteilles = $modeleBouteille->autocomplete('a');
					// var_dump('a');die;
					break;

				default :
					trigger_error('Action invalide.');
			}
		}
	}
