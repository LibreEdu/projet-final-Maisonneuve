<?php
	class Controleur_login extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params['action'])
			{
				case 'index':
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
								$this->afficheVue('login/login', $donnees);
								$this->afficheVue('modeles/bas-de-page');
							}
						}
						// Dans le cas qu’aucun paramètre n’est spécifié, on affiche la page login
						$this->afficheVue('modeles/en-tete');
						$this->afficheVue('login/login');
						$this->afficheVue('modeles/bas-de-page');
					break;
				case 'formulaire':
						 $this->afficheVue('modeles/en-tete');
						 $this->afficheVue('login/formulaire');
						 $this->afficheVue('modeles/bas-de-page');
					break;
				case "sinscrire":
					$modeleUsager = $this->getDAO('Usager');
					$donnees["usager"] = $modeleUsager->obtenir_tous();
					$modeleBouteille = $this->getDAO('Bouteille');
					$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();
					
					$message="";

					//$_SESSION['UserID'] = $_REQUEST['pseudo'];

					//$AfficherFormulaire=1;
				//traitement du formulaire:
					if(isset($_REQUEST['pseudo'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mdp'], $_REQUEST['mdp2'] ))
					{

					  $message = $this->valideFormInscription($_REQUEST['pseudo'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mdp'], $_REQUEST['mdp2']);  

						if(($modeleUsager->obtenirUsager($_REQUEST['pseudo'])))
						{//on vérifie que ce pseudo n'est pas déjà utilisé par un autre membre
							$message = 'Ce pseudo est déjà utilisé.';
								
							$donnees['erreurs'] = $message;
							//echo "Ce pseudo est déjà utilisé.";
						} 

						if($message == "")
						 {
						
							
							// if(!mysqli_query($mysqli,"INSERT INTO vino_usager SET courriel='".$_POST['pseudo']."', hash='".md5($_POST['mdp'])."'"))
							$nouveauSujet = new Usager(0, 0, 1, $params["pseudo"], $params["nom"], $params["prenom"], hash('sha512', $params["mdp"]));
							//$donnees["usager"] = $modeleUsager->sauvegarde($nouveauSujet);
							
								
								 //$donnees['erreurs'] = $message;
								 $modeleUsager->sauvegarde($nouveauSujet);

								 $message = 'Vous êtes inscrit avec succès connectez-vous maintenant!';
								 $donnees['erreurs'] = $message;
								//echo "Vous êtes inscrit avec succès!";
								//on affiche plus le formulaire
								//$AfficherFormulaire=0;
								//$_SESSION['UserID'] = $_REQUEST['pseudo'];
								// $donnees["erreurs"] = $erreurs;
								$this->afficheVue('modeles/en-tete');
								$this->afficheVue('login', $donnees);
								$this->afficheVue('modeles/bas-de-page');

						 }
							
							else
						 {//on crypte le mot de passe avec la fonction propre à PHP: md5()
								//echo "Une erreur s'est produite: ".mysqli_error($mysqli);//je conseille de ne pas afficher les erreurs aux visiteurs mais de l'enregistrer dans un fichier log
							 //$donnees["erreurs"] = $erreurs;
								$this->afficheVue('modeles/en-tete');
								// $vue = "inscription";
		//             			$this->afficheVue($vue, $donnees);	
								$this->afficheFormInscription($message);
								$this->afficheVue('modeles/bas-de-page');
						} 
						//     else 
						//     {
						// //      	$message = 'Vous êtes inscrit avec succès connectez-vous maintenant!';
								
								 // // $donnees['erreurs'] = $message;
						// //         //echo "Vous êtes inscrit avec succès!";
						// //         //on affiche plus le formulaire
						// //        //$AfficherFormulaire=0;
						// //     	//$_SESSION['UserID'] = $_REQUEST['pseudo'];
						// //         $this->afficheVue('modeles/en-tete');
						// //         $this->afficheVue('login', $donnees);
						// //         $this->afficheVue('modeles/bas-de-page');
							}
						else{
							$message = "Paramètres invalides.";

							}
					//var_dump($modeleUsager->obtenirUsager($_REQUEST['pseudo']));
								
					
					
					// $this->afficheVue('modeles/en-tete');
					// $vue = "inscription";
	 //                $this->afficheVue($vue, $donnees);					
					// $this->afficheVue('modeles/bas-de-page');
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
			
			if(!preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#',$courriel))
				$msgErreur .= 'le format courriel doit être réspecter.<br>';
			
			if($nom == '')
				$msgErreur .= 'Le nom ne peut être vide.<br>';

			if(!preg_match('#^[a-zA-Z]+$#',$nom))
				$msgErreur .= 'Le texte ne peut être vide.<br>';

			if($prenom == '')
				$msgErreur .= 'Le prénom ne peut être vide.<br>';

			if(!preg_match('#^[a-zA-Z]+$#',$prenom))
				$msgErreur .= 'Le texte ne peut être vide.<br>';

			if($hash == '')
				$msgErreur .= 'Le mot de passe ne doit pas être vide.<br>';

			if(strlen($hash)>12|| strlen($hash)<5)
				$msgErreur .= 'Le mot de passe doit être ent 6 et 20 caractéres.<br>';

			if(trim($hash) != trim($hash2))
				$msgErreur .= 'Les mots de passe doivent ètre différent.<br>';


			

			// Retourner un message d'erreur
			return $msgErreur;
		}
	}
