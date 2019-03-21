<?php
	class Controleur_login extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params['action'])
			{
				case 'index':
				//var_dump($_SESSION);die;
				 $messageErreur = '';
					if(isset($_REQUEST['user']) && isset($_REQUEST['pass']))
						{
							$modeleUsager = $this->getDAO('Usager');
							
							if($modeleUsager->Authentification($_REQUEST['user'], $_REQUEST['pass']))
							{
								$modeleBouteille = $this->getDAO('Bouteille');
								$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();
								// Mets le nom d’usager dans la variable session UserID,
								// ce qui authentifie l’usager pour les pages protégées
								$_SESSION['UserID'] = $_REQUEST['user'];
								$user = $modeleUsager->obtenirUsager($_REQUEST["user"]);
								$_SESSION["idUsager"] =$user->id_usager;
								$this->afficheVue('modeles/en-tete');
								$this->afficheVue('modeles/menu-usager');
								$this->afficheVue('cellier', $donnees);
								$this->afficheVue('modeles/bas-de-page');
							}
							else
							{
								$messageErreur = 'Mauvaise combinaison username/password';
								// On affiche la page login
								$donnees['erreurs'] = $messageErreur;
								$this->afficheVue('modeles/en-tete');
								$this->afficheVue('modeles/menu-admin');
								$this->afficheVue('login/login', $donnees);
								$this->afficheVue('modeles/bas-de-page');
							}
						}
						// Dans le cas qu’aucun paramètre n’est spécifié, on affiche la page login
						$this->afficheVue('modeles/en-tete');
						$this->afficheVue('modeles/menu-admin');
						$this->afficheVue('login/login');
						$this->afficheVue('modeles/bas-de-page');
					break;

				case 'formulaire':
						$this->afficheVue('modeles/en-tete');
						$this->afficheVue('modeles/menu-admin');
						 $this->afficheVue('login/formulaire');
						 $this->afficheVue('modeles/bas-de-page');
					break;

				case "sinscrire":
					$modeleUsager = $this->getDAO('Usager');
					$donnees["usager"] = $modeleUsager->obtenir_tous();
					$modeleBouteille = $this->getDAO('Bouteille');
					$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();					
					$messageErreur="";
					if(isset($_REQUEST['pseudo'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mdp'], $_REQUEST['mdp2'] ))
					{
						$messageErreur = $this->valideFormInscription($_REQUEST['pseudo'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mdp'], $_REQUEST['mdp2']);  

						if(($modeleUsager->obtenirUsager($_REQUEST['pseudo'])))
						{//on vérifie que ce pseudo n'est pas déjà utilisé par un autre membre
							$messageErreur = ' Ce courriel est déjà utilisé.';
								
							$donnees['erreurs'] = $messageErreur;
							//echo "Ce pseudo est déjà utilisé.";
						} 

						if($messageErreur == "")
						{
							$nouveauUsager = new Usager(0, 0, 1, $params["pseudo"], $params["nom"], $params["prenom"], password_hash($params["mdp"], PASSWORD_DEFAULT) );

							$modeleUsager->sauvegarde($nouveauUsager);
							// $messageErreur = 'Vous êtes inscrit avec succès connectez-vous maintenant!';
							// $donnees['erreurs'] = $messageErreur;
							// $this->afficheVue('modeles/en-tete');
							// $this->afficheVue('');
							// $this->afficheVue('modeles/bas-de-page');
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

		/*=====  Fonction d'affichage du formulaire d'ajout d'un sujet  ======*/		
		public function afficheFormInscription($erreurs = '')
		{
			// Récupérer le modèle sujets
			$modeleUsager = $this->getDAO('Usager');
			// Récupére la liste des sujets
			$donnees['usager'] = $modeleUsager->obtenir_tous();
			// $donnees['Sujets'] = $modeleSujets->ObtenirTousParReponses();

			// Remplir le tableau erreurs
			$donnees['erreurs'] = $erreurs;
			// Afficher le formulaire Ajouter un sujet
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
				$msgErreur .= 'Entrez un nom valide.<br>';

			if($prenom == '')
				$msgErreur .= 'Le prénom ne peut être vide.<br>';

			if(!preg_match("/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{2,30})$/",$prenom))
				$msgErreur .= 'Entrez un prénom valide.<br>';

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
