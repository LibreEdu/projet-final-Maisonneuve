<?php
	class Controleur_Cellier extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params['action'])
			{
				case 'index':
					//recuperation d'usager qui est connecter
					$modeleUsager = $this->getDAO('Usager');		
					$user = $modeleUsager->obtenirUsager($_SESSION["UserID"]);
					$_SESSION['id_usager'] = $user->id_usager;
					//afficher la liste des cellier d'usager qui est connecter
					$modeleCellier = $this->getDAO('Cellier');
					$donnees['celliers'] = $modeleCellier->obtenir_par_id($_SESSION['id_usager']);
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modeles/menu-usager');
					$this->afficheVue('cellier/liste', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'ajouter-form':
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modeles/menu-usager');
					$this->afficheVue('cellier/ajouter');
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'ajouter':
					$modeleCellier = $this->getDAO('Cellier');
					$modeleCellier->ajoutCellier($_SESSION['id_usager']);
					$donnees['celliers'] = $modeleCellier->obtenir_par_id($_SESSION['id_usager']);
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modeles/menu-usager');
					$this->afficheVue('cellier/liste', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'supprimerCellier':
					$body = json_decode(file_get_contents('php://input'));
					$modeleCellier = $this->getDAO('Cellier');
					$modeleCellier->supprimer_par_id($body->id);
					echo json_encode(true);
					break;

				default :
					trigger_error('Action invalide.');
			}
		}
	}
