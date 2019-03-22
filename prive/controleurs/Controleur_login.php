<?php
/* Controleur login qui gére la connexion et l'inscription d'un usager*/
	class Controleur_login extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params['action'])
			{
				case 'index':
					$messageErreur = '';
					// Si on vient du formulaire
					if ( isset($_REQUEST['user']) && isset($_REQUEST['pass']) )
					{
						$modeleUsager = $this->getDAO('Usager');
						if($modeleUsager->Authentification($_REQUEST['user'], $_REQUEST['pass']))
						{
							// Mets le nom d’usager dans la variable session UserID,
							// ce qui authentifie l’usager pour les pages protégées
							$_SESSION['UserID'] = $_REQUEST['user'];
							$user = $modeleUsager->obtenirUsager($_REQUEST["user"]);
							// Mets le'id de l’usager dans la variable session idUsager,
							$_SESSION["idUsager"] = $user->id_usager;
							$_SESSION["admin"] = $user->admin;
							$_SESSION["prenom"] = $user->prenom;
						}
						else
						{
							$messageErreur = 'Mauvaise combinaison username/password';
							// On affiche la page login
							$donnees['erreurs'] = $messageErreur;
							$this->afficheVue('modeles/en-tete');
							$this->afficheVue('modeles/menu-login');
							$this->afficheVue('login/login', $donnees);
							$this->afficheVue('modeles/bas-de-page');
						}
					}

					// Le contrôleur login est le contrôleur par défaut,
					// donc si quelqu’un de connecté va à la racine du site,
					// il faut le rediriger correctement
					if ( isset($_SESSION["admin"]) && $_SESSION["admin"] == true)
					{
						header('Location: ' . BASEURL . 'index.php?admin');
					} elseif ( isset($_SESSION["idUsager"]) && $_SESSION["idUsager"] == true)
					{
						header('Location: ' . BASEURL . 'index.php?cellier');
					} else {
						$this->afficheVue('modeles/menu-login');
						$this->afficheVue('login/login');
						$this->afficheVue('modeles/bas-de-page');
					}
				break;

					// Affichage du formulaire d'inscription
				case 'formulaire':
						$this->afficheVue('modeles/en-tete');
						$this->afficheVue('modeles/menu-login');
						 $this->afficheVue('login/formulaire');
						 $this->afficheVue('modeles/bas-de-page');
					break;

					/*Gestion de l'inscription*/ 
				case "sinscrire":
					//Récupérer le modele usager
					$modeleUsager = $this->getDAO('Usager');
					$donnees["usager"] = $modeleUsager->obtenir_tous();
					//Récupérer le modele bouteille 
					$modeleBouteille = $this->getDAO('Bouteille');
					$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();

					$messageErreur="";
					if(isset($_REQUEST['pseudo'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mdp'], $_REQUEST['mdp2'] ))
					{
						//Appel de la fonction valideFormInscription et verifier quesqu'elle retourne 
						$messageErreur = $this->valideFormInscription($_REQUEST['pseudo'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mdp'], $_REQUEST['mdp2']);  

						if(($modeleUsager->obtenirUsager($_REQUEST['pseudo'])))
						{//on vérifie que ce pseudo n'est pas déjà utilisé par un autre membre
							$messageErreur = ' Ce courriel est déjà utilisé.';
								
							$donnees['erreurs'] = $messageErreur;							
						} 

						if($messageErreur == "")
						{// Procéder à l'insertion dans la table vino_usager
							$nouveauUsager = new Usager(0, 0, $params["pseudo"], $params["nom"], $params["prenom"], password_hash($params["mdp"], PASSWORD_DEFAULT) );

							$modeleUsager->sauvegarde($nouveauUsager);
							//Affichage
							header('Location: ' . BASEURL);
						} else
						{
							$this->afficheVue('modeles/en-tete');
							$this->afficheVue('modeles/menu-admin');
							$this->afficheFormInscription($messageErreur);
							$this->afficheVue('modeles/bas-de-page');
						} 
					}
					else
					{
						$messageErreur = "Paramètres invalides.";
					}
					break;

				case 'logout':
					// Supprime la session en lui assignant un tableau vide
					$_SESSION = array();
			
					// Supprime le cookie de session en créant un nouveau cookie
					// avec la date d’expiration dans le passé
					if(isset($_COOKIE[session_name()]))
					{
						setcookie(session_name(), '', time() - 3600);
					}
			
					// Détruire la session
					session_destroy();
					header('Location: ' . BASEURL);
					break;
				default :
					trigger_error('Action invalide.');
			}
		}

		/*=====  Fonction d'affichage du formulaire d'ajout d'un usager  ======*/		
		public function afficheFormInscription($erreurs = '')
		{
			// Récupérer le modèle udager
			$modeleUsager = $this->getDAO('Usager');
			// Récupére la liste des usager
			$donnees['usager'] = $modeleUsager->obtenir_tous();

			// Remplir le tableau erreurs
			$donnees['erreurs'] = $erreurs;
			// Afficher le formulaire du login
			$this->afficheVue('login/formulaire', $donnees);
		}

		 /*=====  Fonction de validation du formulaire d'inscription ======*/

		public function valideFormInscription($courriel, $nom, $prenom, $hash ,$hash2)
		{
			// Initialiser le message d'erreur
			$msgErreur = '';

			// Récupérer le titre
			$courriel = trim($courriel);
			// et le texte
			$nom = trim($nom);
			$prenom = trim($prenom);
			$hash = trim($hash);
			
			if($courriel == '')
				$msgErreur .= 'Le champ Courriel est vide.<br>';
			
			if(!preg_match("/^[A-Z0-9.]+@(([A-Z]+\\.)+[A-Z]{2,6})$/i",$courriel))
				$msgErreur .= 'le format courriel doit être réspecter.<br>';
			
			if($nom == '')
				$msgErreur .= 'Le nom ne peut être vide.<br>';

			if(!preg_match("/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{2,30})$/",$nom))
				$msgErreur .= 'Entrez au moins deux caractéres.<br>';

			if($prenom == '')
				$msgErreur .= 'Le prénom ne peut être vide.<br>';

			if(!preg_match("/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{2,30})$/",$prenom))
				$msgErreur .= 'Entrez au moins deux caractéres.<br>';

			if($hash == '')
				$msgErreur .= 'Le mot de passe ne doit pas être vide.<br>';

			if(strlen($hash)>12|| strlen($hash)<5)
				$msgErreur .= 'Le mot de passe doit être entre 6 et 12 caractéres.<br>';

			if(trim($hash) != trim($hash2))
				$msgErreur .= 'Les mots de passe doivent ètre identique.<br>';

			// Retourner un message d'erreur
			return $msgErreur;
		}
	}
