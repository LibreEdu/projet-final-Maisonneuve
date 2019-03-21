<?php
	class Controleur_uCellier extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params['action'])
			{
				case 'index':
					$modeleCellier = $this->getDAO('Cellier');
					$donnees['celliers'] = $modeleCellier->obtenir_par_id(1);
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('cellier/liste', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'ajouter-form':
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('cellier/ajouter');
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'ajouter':
					echo "string";
					$modeleCellier = $this->getDAO('Cellier');
					$modeleCellier->ajoutCellier();
					$donnees['celliers'] = $modeleCellier->obtenir_par_id(1);
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('cellier/liste', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				/*case 'visiterCellier-js':
					$body = json_decode(file_get_contents('php://input'));
					$modeleBouteille = $this->getDAO('Bouteille');
					$donnees['bouteilles'] = $modeleBouteille->obtenir_par_id_cellier($body->id);
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;*/

				case 'supprimerCellier':
					$body = json_decode(file_get_contents('php://input'));
					$modeleCellier = $this->getDAO('Cellier');
					$donnees['celliers'] = $modeleCellier->supprimer_par_id($body->id);
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('cellier/liste', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				default :
					trigger_error('Action invalide.');
			}
		}
	}
