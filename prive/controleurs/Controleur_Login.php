<?php

/**
 * Gestion de la connexion et de l’inscription de l’usager.
 * 
 * @package  Vino
 * @author   Charef Eddine Yagoubi
 * @version  1.0
 */
class Controleur_Login extends Controleur
{
	/**
	 * @var object $modele_usager Le modèle Modele_Usager.
	 */
	private $modele_usager;


	/**
	 * Initialise les modèles.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		$this->modele_usager = $this->modele('modele_usager');
	}


	/**
	 * Récupère la requête de l’utilisateur afin de la traiter.
	 * 
	 * @param array $params Requête de l'utilisateur ($_REQUEST).
	 * 
	 * @return void
	 */
	public function traite(array $params)
	{
		switch($params['action'])
		{
			case 'index':
				$this->index();
			break;

			case 'formulaire':
				$this->formulaire();
				break;

			case 'inscrire':
				$this->inscrire($params);
				break;

			case 'logout':
				$this->logout();
				break;

			case 'formulaireModification':
				$this->formulaireModification();
				break;

			case 'modifier':
				$this->modifier();
				break;

			default :
				trigger_error('Action invalide.');
		}
	}

	/**
	 * Affiche la page login
	 *
	 * Le contrôleur login est le contrôleur par défaut,
	 * donc si quelqu’un se connecte va à la racine du site,
	 * il faut le rediriger correctement
	 * 
	 * @return void
	 */
	public function index()
	{
		$messageErreur = '';
		// Si on vient du formulaire
		if ( isset($_REQUEST['courriel']) && isset($_REQUEST['mot_de_passe']) )
		{
			//Si l'usager est authentifier
			if($this->modele_usager->Authentification($_REQUEST['courriel'], $_REQUEST['mot_de_passe']))
			{
				// Mets le nom d’usager dans la variable session UserID,
				// ce qui authentifie l’usager pour les pages protégées
				//$_SESSION['UserID'] = $_REQUEST['courriel'];
				$user = $this->modele_usager->obtenirUsager($_REQUEST['courriel']);
				// Mets le'id de l’usager dans la variable session idUsager,
				$_SESSION['id_usager'] = $user->id_usager;
				$_SESSION['admin'] = $user->admin;
				$_SESSION['prenom'] = $user->prenom;
			}
			else
			{
				$messageErreur = ' Mauvaise combinaison username/password';

				// On affiche la page login
				$donnees['erreurs'] = $messageErreur;
				$this->afficheVue('modeles/en-tete');
				$this->afficheVue('modeles/menu-login');
				$this->afficheVue('login/login', $donnees);
				// $this->afficheVue('modeles/bas-de-page');
			}
		}

		// Si je suis connecté en tant qu’administrateur
		if ( isset($_SESSION['admin']) && $_SESSION['admin'] == true )
		{
			header('Location: ' . site_url('importation') );
		// Si je suis connecté en tant qu’usager
		} elseif ( isset($_SESSION['id_usager']) && $_SESSION['id_usager'] == true )
		{
			header('Location: ' .  site_url('cellier') );
		} else {
			//vue par défaut
			$this->afficheVue('modeles/en-tete');
			$this->afficheVue('modeles/menu-login');
			$this->afficheVue('login/login');
			// $this->afficheVue('modeles/bas-de-page');
		}
	}


	/**
	 * Fonction Affichage du formulaire d’inscription
	 * 
	 * @return void
	 */
	public function formulaire()
	{
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-login');
		$this->afficheVue('login/formulaire');
		// $this->afficheVue('modeles/bas-de-page');
	}


	/**
	 * Fonction Affichage du formulaire de modification
	 * 
	 * @return void
	 */
	public function formulaireModification()
	{
		$idUsager= $_SESSION['id_usager'];
		$donnees['usager'] = $this->modele_usager->obtenir_par_id($_GET['id']); 
		// si $idUsager est différent de l'id récuperer on sortpour réstrindre l'accées par url 
		if ($idUsager != $_GET['id']) {
			header('Location: ' . site_url('login&action=logout') );
		}
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('login/formulaire-modification', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}


	/**
	 * Fonction modifier qui gére la modification des informations d’un usager connecté
	 * 
	 * @return void
	 */
	public function modifier()
	{
		$idUsager= $_SESSION['id_usager'];

		if ($idUsager == null) {
			header('Location: ' . site_url('login&action=logout') );
		}
		// if ( isset($_SESSION['id_usager']) )
		// {

			$donnees['usager'] = $this->modele_usager->obtenir_par_id($_GET['id']);
			//initialiser le message d'Erreur
			$messageErreur='';
			//Si on récupére tous les paramétres
			if(isset($_REQUEST['courriel'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mot_de_passe'], $_REQUEST['mdp1'], $_REQUEST['mdp2']))
			{
				//si on ne veut pas changer le mot de passe mais les autres informations
				if ($_REQUEST['mot_de_passe']=='')
				{
					$messageErreur = $this->valideFormSansMdp($_REQUEST['courriel'], $_REQUEST['nom'], $_REQUEST['prenom']);
					//Si pas de message d'erreur
					if($messageErreur == '')
					{
						//modifier les informations de l'usager sans son mot de passe
						$this->modele_usager->modifierSansMotDePasse();
						//récupérer les données de l'usager
						$donnees['usager'] = $this->modele_usager->obtenir_par_id($_GET['id']);		
						// Mets le'id de l’usager dans la variable session idUsager,
						$_SESSION['courriel'] = $donnees['usager']->courriel;
						$_SESSION['nom'] = $donnees['usager']->nom;
						$_SESSION['prenom'] = $donnees['usager']->prenom;
						$this->afficheVue('modeles/en-tete');
						$this->afficheVue('modeles/menu-usager');
						$this->afficheVue('login/formulaire-modification', $donnees);
						$this->afficheVue('modeles/bas-de-page');
					}
					else
					{
						//Affichage de la page form-modification avec l'erreur
						$this->afficheFormModification($messageErreur,$donnees);
					}
				}
				//Si on veut changer le mot de passe
				else
				{
					$messageErreur = $this->valideFormSansMdp($_REQUEST['courriel'], $_REQUEST['nom'], $_REQUEST['prenom']);
					$messageErreur .= $this->valideFormModification($_REQUEST['mot_de_passe'], $_REQUEST['mdp1'], $_REQUEST['mdp2']);
				//Si l'usger est le même et le mot de passe corespond à celui dans la base de données
					if($this->modele_usager->Authentification($_REQUEST['courriel'], $_REQUEST['mot_de_passe']))
					{
						//Si pas de message d'erreur
						if($messageErreur == '')
						{
							// Procéder à la modification dans la table vino_usager
							$this->modele_usager->modifier();
							//Obtenir l'usager modifier
							$donnees['usager'] = $this->modele_usager->obtenir_par_id($_GET['id']);
							// Mets le'id de l’usager dans la variable session idUsager,
							$_SESSION['courriel'] = $donnees['usager']->courriel;
							$_SESSION['nom'] = $donnees['usager']->nom;
							$_SESSION['prenom'] = $donnees['usager']->prenom;
							
							//Afficher les vues
							$this->afficheVue('modeles/en-tete');
							$this->afficheVue('modeles/menu-usager');
							$this->afficheVue('login/formulaire-modification', $donnees);
							$this->afficheVue('modeles/bas-de-page');
						}
						else
						{//Affichage de la page form-modification avec l'erreurr
							$this->afficheFormModification($messageErreur,$donnees);
						}
					}
					else
					{
						$messageErreur = " Le mot de passe ne correspond pas à votre ancien mot de passe";
						// On affiche la page form-modification avec l'erreur
						$donnees['erreurs'] = $messageErreur;
						$this->afficheFormModification($messageErreur,$donnees);
					}
				}
			}
			else
			{
				$messageErreur = 'Paramètres invalides.';
			}
		}
		// else{
		// 	header('Location: ' . site_url('login&action=logout') );
		// }

	/**
	 * Fonction inscrire qui gére l’inscription d’un nouvel usager
	 * 
	 * @param array $params Tableau de paramètres
	 * 
	 * @return void
	 */
	public function inscrire($params)
	{
		$donnees['usager'] = $this->modele_usager->obtenir_tous();

		$messageErreur='';
		if(isset($_REQUEST['courriel'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mdp'], $_REQUEST['mdp2'] ))
		{
			// Appel de la fonction valideFormSansMdp et verifier ce qu’elle retourne 
			$messageErreur = $this->valideFormSansMdp($_REQUEST['courriel'], $_REQUEST['nom'], $_REQUEST['prenom']);

			// Appel de la fonction valideFormInscription et verifier ce qu’elle retourne 
			$messageErreur .= $this->valideFormInscription($_REQUEST['mdp'], $_REQUEST['mdp2']);  

			if(($this->modele_usager->obtenirUsager($_REQUEST['courriel'])))
			{// vérifie que ce courriel n’est pas déjà utilisé par un autre membre
				$messageErreur = ' Ce courriel est déjà utilisé.';
				$donnees['erreurs'] = $messageErreur;
			} 
			// Si il n'y a pas de message d'erreur
			if($messageErreur == '')
			{
				$nouveauUsager = new Classe_Usager(0, 0, $params['courriel'], $params['nom'], $params['prenom'], password_hash($params['mdp'], PASSWORD_DEFAULT) );
				// Procéder à l’insertion dans la table vino_usager
				$this->modele_usager->inscrire($nouveauUsager);

				//Renvoi à la page par défaut pour se logger
				//header( 'Location: ' . base_url() );
				$messageErreur = ' Bravo! votre compte a été créé';

				// On affiche la page login
				$donnees['erreurs'] = $messageErreur;
				$this->afficheVue('modeles/en-tete');
				$this->afficheVue('modeles/menu-login');
				$this->afficheVue('login/login', $donnees);
			} else
			{//Affichage de la page d'inscription avec l'erreur
				$this->afficheFormInscription($messageErreur);
			} 
		}
		else
		{
			$messageErreur = 'Paramètres invalides.';
		}
	}


	/**
	 * Gére la déconnexion
	 * 
	 * @return void
	 */
	public function logout()
	{
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
		header( 'Location: ' . base_url() );
	}


	/**
	 * Affiche le formulaire d’ajout d’un usager
	 * 
	 * @param string $erreurs le message d’erreur
	 * 
	 * @return void
	 */
	public function afficheFormInscription($erreurs = '')
	{
		// Récupére la liste des usagers
		$donnees['usager'] = $this->modele_usager->obtenir_tous();

		// Remplir le tableau erreurs
		$donnees['erreurs'] = $erreurs;
		// Afficher le formulaire du login
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-login');
		$this->afficheVue('login/formulaire', $donnees);
		// $this->afficheVue('modeles/bas-de-page');
	}


	/**
	 * Affiche du formulaire de modification
	 * 
	 * @param string $erreurs Le message d’erreur
	 * 
	 * @return void
	 */
	public function afficheFormModification($erreurs = '')
	{
		// Récupére la liste des usagers
		$donnees['usager'] = $this->modele_usager->obtenir_tous();

		$donnees['usager'] = $this->modele_usager->obtenir_par_id($_GET['id']);
		$donnees['erreurs'] = $erreurs;

		// Afficher le formulaire du login
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('login/formulaire-modification', $donnees);
		$this->afficheVue('modeles/bas-de-page');
	}


	/**
	 * Valide le formulaire d’inscription
	 * 
	 * @param string $mdp1 Mot de passe
	 * @param string $mdp2 Confirmation du mot de passe
	 * 
	 * @return retourne Le message d'erreur
	 */
	public function valideFormInscription($mdp1 ,$mdp2)
	{
		// Initialiser le message d’erreur
		$msgErreur = '';
		
		$mdp1 = trim($mdp1);
		// et le deuxiéme mot de passe
		$mdp2 = trim($mdp2);
		
		if($mdp1 == '')
			$msgErreur .= 'Le mot de passe ne doit pas être vide.<br>';

		if(strlen($mdp1)>12|| strlen($mdp1)<5)
			$msgErreur .= 'Le mot de passe doit être entre 6 et 12 caractères.<br>';

		if($mdp1 != $mdp2)
			$msgErreur .= 'Les mots de passe doivent ètre identiques.<br>';

		// Retourner le message d’erreur
		return $msgErreur;
	}


	/**
	 * Fonction de validation du formulaire d’inscription
	 * @param $courriel, $nom, $prenom, $mdp ,$mdp2
	 * @return retourne le message d'erreur
	 */
	public function valideFormModification($mdp1, $mdp2, $mdp3)
	{
		// Initialiser le message d'erreur
		$msgErreur = '';

		$mdp1 = trim($mdp1);
		// et le deuxiéme mot de passe
		$mdp2 = trim($mdp2);
		// et le troisiemme mot de passe
		$mdp3 = trim($mdp3);
		
		if($mdp2 == '' || $mdp3 == '')
			$msgErreur .= 'Le mot de passe ne doit pas être vide.<br>';

		if(strlen($mdp2)>12|| strlen($mdp2)<5)
			$msgErreur .= 'Le mot de passe doit être entre 6 et 12 caractères.<br>';

		if(strlen($mdp3)>12|| strlen($mdp3)<5)
			$msgErreur .= 'Le mot de passe doit être entre 6 et 12 caractères.<br>';

		if($mdp2 != $mdp3)
			$msgErreur .= 'Les deux mots de passe doivent ètre identiques.<br>';

		// Retourner un message d'erreur
		return $msgErreur;
	}

	/**
	 * Valide le formulaire d’inscription sans mot de passe
	 * 
	 * @param string $courriel Courriel de l’usager
	 * @param string $nom Nom de l’usager
	 * @param string $prenom Prénom de l’usager
	 * 
	 * @return string Le message d’erreur
	 */
	public function valideFormSansMdp($courriel, $nom, $prenom)
	{
		// Initialiser le message d’erreur
		$msgErreur = '';

		// Récupérer le courriel
		$courriel = trim($courriel);
		// et le nom
		$nom = trim($nom);
		// et le prenom
		$prenom = trim($prenom);
		
		if($courriel == '')
			$msgErreur .= 'Le champ Courriel est vide.<br>';
		
		if(!preg_match("/^[A-Z0-9.]+@(([A-Z]+\\.)+[A-Z]{2,6})$/i",$courriel))
			$msgErreur .= 'Le format courriel doit être réspecter.<br>';
		
		if($nom == '')
			$msgErreur .= 'Le nom ne peut être vide.<br>';

		if(!preg_match("/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{2,30})$/",$nom))
			$msgErreur .= 'Entrez au moins deux caractères dans le nom et pas de chiffres.<br>';

		if($prenom == '')
			$msgErreur .= 'Le prénom ne peut être vide.<br>';

		if(!preg_match("/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{2,30})$/",$prenom))
			$msgErreur .= 'Entrez au moins deux caractères dans le prénom et pas de chiffres.<br>';

		// Retourner un message d’erreur
		return $msgErreur;
	}
}
