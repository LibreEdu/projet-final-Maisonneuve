<?php
	class Controleur_BouteilleSaq extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params['action'])
			{
				case 'index':
					$modeleBouteilleSaq = $this->getDAO('BouteilleSaq');	
					$donnees['bouteilleSaq'] = $modeleBouteilleSaq->obtenir_tous();
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('bouteille/bouteilleSaq', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				default :
					trigger_error('Action invalide.');
			}
		}
	}