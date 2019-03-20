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

				//case 'index':
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

					case "inscription":

					$modeleUsager = $this->getDAO('Usager');
					$donnees["usager"] = $modeleUsager->obtenir_tous();
					$modeleBouteille = $this->getDAO('Bouteille');
					$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();

					//$_SESSION['UserID'] = $_REQUEST['pseudo'];

					//$AfficherFormulaire=1;
				//traitement du formulaire:
					if(isset($_POST['pseudo'], $_POST['nom'], $_POST['prenom'],$_POST['mdp'], $_POST['mdp2'] ))
					{
						$_SESSION['UserID'] = $_REQUEST['pseudo'];
					//l'utilisateur à cliqué sur "S'inscrire", on demande donc si les champs sont défini avec "isset"
					    if(empty($_POST['pseudo']))
					    {
					    	$message = 'Le champ Courriel est vide';
								
							$donnees['erreurs'] = $message;
					        //echo "Le champ Pseudo est vide.";
					    } 
					    elseif(!preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#",$_POST['pseudo']))
					    {
					    	$message = 'le format devra réspecter celui du courriel.';
								
							$donnees['erreurs'] = $message;
					        //echo "Le Pseudo doit être renseigné en lettres minuscules sans accents, sans caractères spéciaux.";
					    }

					    elseif(!preg_match("#^[a-z0-9]+$#",$_POST['nom']))
					    {
					    	$message = 'Le Nom ne doit pas contenir de chiffres';
								
							$donnees['erreurs'] = $message;
					        //echo "Le Pseudo doit être renseigné sans chiffres ni caractères spéciaux.";
					    }

					    elseif(!preg_match("#^[a-z0-9]+$#",$_POST['prenom']))
					    {
					    	$message = 'Le Prénom ne doit pas contenir de chiffres';
								
							$donnees['erreurs'] = $message;
					        //echo "Le Prénom doit être renseigné sans chiffres ni caractères spéciaux.";
					    }   
					  //   elseif(strlen($_POST['pseudo'])>25)
					  //   {
					  //   	$message = 'Le pseudo est trop long, il dépasse 25 caractères.';
								
							// $donnees['erreurs'] = $message;
					  //      // echo "Le pseudo est trop long, il dépasse 25 caractères.";
					  //   } 
					    elseif(empty($_POST['mdp']))
					    {//le champ mot de passe est vide
					    	$message = 'Le champ Mot de passe est vide.';
								
							$donnees['erreurs'] = $message;
					        //echo "Le champ Mot de passe est vide.";
					    }
					    elseif(strlen($_POST['mdp'])>12|| strlen($_POST['mdp'])<5)
					    {
					    	$message = 'Le mot de passe doit contenir entre 6 à 12 caracteres maximum.';
								
							$donnees['erreurs'] = $message;
					        //echo "Le mot de passe doit contenir entre 6 à 12 caracteres maximum.";
					    }
					    elseif (($_POST['mdp']) != ($_POST['mdp2']) ) 
					    {
					      	$message = 'Les mots de passe doivent être identique.';
								
							$donnees['erreurs'] = $message;
					    }  
					    elseif(($modeleUsager->obtenirUsager($_REQUEST['pseudo'])))
					    {//on vérifie que ce pseudo n'est pas déjà utilisé par un autre membre
							$message = 'Ce pseudo est déjà utilisé.';
								
							$donnees['erreurs'] = $message;
					        //echo "Ce pseudo est déjà utilisé.";
					    } 
					    else 
					    {
					        
					        // if(!mysqli_query($mysqli,"INSERT INTO vino_usager SET courriel='".$_POST['pseudo']."', hash='".md5($_POST['mdp'])."'"))
					    	$nouveauSujet = new Usager(0, 0, 1, $params["pseudo"], $params["nom"], $params["prenom"], hash('sha512', $params["mdp"]));
					    	//$donnees["usager"] = $modeleUsager->sauvegarde($nouveauSujet);
					        
					        if(!$modeleUsager->sauvegarde($nouveauSujet))
					        {//on crypte le mot de passe avec la fonction propre à PHP: md5()
					            echo "Une erreur s'est produite: ".mysqli_error($mysqli);//je conseille de ne pas afficher les erreurs aux visiteurs mais de l'enregistrer dans un fichier log
					        } 
					        else 
					        {
					        	$message = 'Vous êtes inscrit avec succès!';
								
								$donnees['erreurs'] = $message;
					            //echo "Vous êtes inscrit avec succès!";
					            //on affiche plus le formulaire
					            $AfficherFormulaire=0;
					            $this->afficheVue('modeles/en-tete');
					            $this->afficheVue('cellier', $donnees);
					            $this->afficheVue('modeles/bas-de-page');
					        }
					    }
					}
					//var_dump($modeleUsager->obtenirUsager($_REQUEST['pseudo']));
								
					
					
					$this->afficheVue('modeles/en-tete');
					$vue = "inscription";
                    $this->afficheVue($vue, $donnees);					
					$this->afficheVue('modeles/bas-de-page');
					break;

				
				default :
					trigger_error('Action invalide.');
			}
		}
	}
