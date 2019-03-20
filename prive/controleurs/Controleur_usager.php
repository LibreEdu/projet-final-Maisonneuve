<?php
	class Controleur_usager extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params['action'])
			{
				case 'afficheUsagers':
					$modeleUsager = $this->getDAO('Usager');
					
					$donnees['usager'] = $modeleUsager->obtenir_tous();
					
					$this->afficheVue('modeles/en-tete');
					//$this->afficheVue('cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'index':
				case 'login':
				 $message = '';
					if(isset($_REQUEST['user']) && isset($_REQUEST['pass']))
						{
							//$usager = new Usager();
							 $modeleUsager = $this->getDAO('Usager');
							 $modeleBouteille = $this->getDAO('Bouteille');
							 $donnees['bouteilles'] = $modeleBouteille->obtenir_tous();
							 
						   if($modeleUsager->Authentification($_REQUEST['user'], $_REQUEST['pass']))
							{
								// Mets le nom d’usager dans la variable session UserID,
								// ce qui authentifie l’usager pour les pages protégées
								$_SESSION['UserID'] = $_REQUEST['user'];

								$this->afficheVue('modeles/en-tete');
								$this->afficheVue('cellier', $donnees);
								$this->afficheVue('modeles/bas-de-page');
							}
							else
							{
								$message = 'Mauvaise combinaison username/password';
								// On affiche la page login
								$donnees['erreurs'] = $message;
								$this->afficheVue('modeles/en-tete');
								$vue = 'login';
								$this->afficheVue($vue, $donnees);
								$this->afficheVue('modeles/bas-de-page');
							}
						}
						// Dans le cas qu’aucun paramètre n’est spécifié, on affiche la page login
						$this->afficheVue('modeles/en-tete');
						$vue = 'login';
						$this->afficheVue($vue);
						$this->afficheVue('modeles/bas-de-page');
					
					
					break;

				case 'Logout':
					// Supprime la session en lui assignant un tableau vide
					$_SESSION = array();
			
					// Supprime le cookie de session en créant un nouveau cookie
					// avec la date d’expiration dans le passé
					if(isset($_COOKIE[session_name()]))
					{
						setcookie(session_name(), '', time() - 3600);
					}
			
					// Iétruire la session
					session_destroy();
					$this->afficheVue('modeles/en-tete');
					$vue = 'login';
					$this->afficheVue($vue);
					$this->afficheVue('modeles/bas-de-page');
					break;
				
				default :
					trigger_error('Action invalide.');
			}
		}
	}
