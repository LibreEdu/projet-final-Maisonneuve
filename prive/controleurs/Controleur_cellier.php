<?php
	class Controleur_cellier extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params['action'])
			{
				case 'index':
					$modeleCellier = $this->getDAO('Cellier');
					$donnees['celliers'] = $modeleCellier->obtenir_par_id(1);
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('listesCelliers', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				default :
					trigger_error('Action invalide.');
			}
		}
	}
