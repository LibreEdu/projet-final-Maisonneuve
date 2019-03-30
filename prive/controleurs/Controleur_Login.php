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
	 * 
	 */
	public function __construct()
	{
		$this->modele_usager = $this->modele('modele_usager');
		$this->modele_cellier = $this->modele('modele_cellier');
	}

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
	 * Fonction appelée par défaut qui affiche la page login
	 *
	 * Le contrôleur login est le contrôleur par défaut,
	 * donc si quelqu’un se connecte va à la racine du site,
	 * il faut le rediriger correctement
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
				$messageErreur = 'Mauvaise combinaison username/password';
				// On affiche la page login
				$donnees['erreurs'] = $messageErreur;
				$this->afficheVue('modeles/en-tete');
				$this->afficheVue('modeles/menu-login');
				$this->afficheVue('login/login', $donnees);
				$this->afficheVue('modeles/bas-de-page');
			}
		}

		// Si je suis connecté en tant qu'administrateur
		if ( isset($_SESSION['admin']) && $_SESSION['admin'] == true )
		{
			header('Location: ' . site_url('importation') );
		// Si je suis connecté en tant qu'usager
		} elseif ( isset($_SESSION['id_usager']) && $_SESSION['id_usager'] == true )
		{
			header('Location: ' .  site_url('cellier') );
		} else {
			//vue par défaut
			$this->afficheVue('modeles/en-tete');
			$this->afficheVue('modeles/menu-login');
			$this->afficheVue('login/login');
			$this->afficheVue('modeles/bas-de-page');
		}
	}

	/**
	 * Fonction Affichage du formulaire d'inscription
	 */
	public function formulaire()
	{
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-login');
		$this->afficheVue('login/formulaire');
		$this->afficheVue('modeles/bas-de-page');
	}

	/**
	 * Fonction Affichage du formulaire de modification
	 */
	public function formulaireModification()
	{
		//$donnees['usager'] = $this->modele_usager->obtenir_tous();
		$idUsager= $_SESSION['id_usager'];
		$donnees['usager'] = $this->modele_usager->obtenir_par_id($_GET['id']); 

		if ($idUsager != $_GET['id']) {
			header('Location: ' . site_url('login&action=logout') );
		}
		//$id_usager2 = $this->modele_usager->appartient($_GET['id'],$_SESSION['id_usager']);
		// if ( isset($_SESSION['id_usager']) )
		// {
		 // $donnees['usager'] = $this->modele_usager->obtenir_par_id($_GET['id']); 
		// $donnees['titre'] = 'Modifier Votre compte';
		// $donnees['actionBouton'] = 'modifier';
		// $donnees['titreBouton'] = 'Modifier l’usager';
		// $donnees['classeBouton'] = 'mdl-button mdl-js-button mdl-button--raised';
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-usager');
		$this->afficheVue('login/formulaire-modification', $donnees);
		$this->afficheVue('modeles/bas-de-page');
		// }
		// else{
		// 	header('Location: ' . site_url('login&action=logout') );
		// }
	}

	/**
	 * Foncton modifier qui gére la modification des informations 
	 * d'un usager connecté
	 */
	public function modifier()
	{
		$idUsager= $_SESSION['id_usager'];

		if ($idUsager == null) {
			header('Location: ' . site_url('login&action=logout') );
		}
		if ( isset($_SESSION['id_usager']) )
		{

			$donnees['usager'] = $this->modele_usager->obtenir_par_id($_GET['id']);
		
			$messageErreur='';
			if(isset($_REQUEST['courriel'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mot_de_passe'], $_REQUEST['mdp1'], $_REQUEST['mdp2']))
			{
				  
				$messageErreur = $this->valideFormModification($_REQUEST['courriel'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mot_de_passe'], $_REQUEST['mdp1'], $_REQUEST['mdp2']);
				//Si l'usger est le même et le mot de passe corespond à celui dana la base de données
				if($this->modele_usager->Authentification($_REQUEST['courriel'], $_REQUEST['mot_de_passe']))
				{

					if($messageErreur == '')
					{
						// Procéder à la modification dans la table vino_usager
						$this->modele_usager->modifier();
						//$donnees['usager'][0]
						$donnees['usager'] = $this->modele_usager->obtenir_par_id($_GET['id']); 
						//var_dump($donnees);
						 //$user = $this->modele_usager->obtenirUsager($_REQUEST['courriel']);
				// Mets le'id de l’usager dans la variable session idUsager,
						$_SESSION['courriel'] = $donnees['usager'][0]->courriel;
						$_SESSION['nom'] = $donnees['usager'][0]->nom;
						$_SESSION['prenom'] = $donnees['usager'][0]->prenom;
						
						//echo '<script>alert("Les informations ont été modifier.")</script>';
						// echo '<script>document.location.reload(true)</script>';
						
						$this->afficheVue('modeles/en-tete');
						$this->afficheVue('modeles/menu-usager');
						$this->afficheVue('login/formulaire-modification', $donnees);
						//echo '<script>document.location.reload()</script>';
						
						// header('Location: ' . site_url( 'cellier' ));
						//$this->afficheVue('cellier/liste', $donnees);
						$this->afficheVue('modeles/bas-de-page');
					}
					else
					{//Affichage de la page form-modification avec l'erreurr
						$this->afficheVue('modeles/en-tete');
						$this->afficheVue('modeles/menu-usager');
						$this->afficheFormModification($messageErreur,$donnees);
						$this->afficheVue('modeles/bas-de-page');
					}
				}
				else
				{
					$messageErreur = "Le mot de passe n'est pas valide";
					// On affiche la page form-modification avec l'erreur
					$donnees['erreurs'] = $messageErreur;
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modeles/menu-usager');
					$this->afficheFormModification($messageErreur,$donnees);
					$this->afficheVue('modeles/bas-de-page');

				} 
			}
			else
			{
				$messageErreur = 'Paramètres invalides.';
			}
		}
		else{
			header('Location: ' . site_url('login&action=logout') );
		}
	}

	/**
	 * Foncton inscrire qui gére l'inscription d'un nouvel usager
	 */
	public function inscrire($params)
	{
		$donnees['usager'] = $this->modele_usager->obtenir_tous();

		$messageErreur='';
		if(isset($_REQUEST['courriel'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mdp'], $_REQUEST['mdp2'] ))
		{
			// Appel de la fonction valideFormInscription et verifier ce qu’elle retourne 
			$messageErreur = $this->valideFormInscription($_REQUEST['courriel'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mdp'], $_REQUEST['mdp2']);  

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
				header( 'Location: ' . base_url() );
			} else
			{//Affichage de la page login avec l'erreur
				$this->afficheVue('modeles/en-tete');
				$this->afficheVue('modeles/menu-admin');
				$this->afficheFormInscription($messageErreur);
				$this->afficheVue('modeles/bas-de-page');
			} 
		}
		else
		{
			$messageErreur = 'Paramètres invalides.';
		}
	}

	/**
	 * Foncton logout qui gére la déconnexion
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
	 * Fonction d'affichage du formulaire d'ajout d'un usager
	 * @param $erreurs le message d'ereur
	 */
	public function afficheFormInscription($erreurs = '')
	{
		// Récupére la liste des usagers
		$donnees['usager'] = $this->modele_usager->obtenir_tous();

		// Remplir le tableau erreurs
		$donnees['erreurs'] = $erreurs;
		// Afficher le formulaire du login
		$this->afficheVue('login/formulaire', $donnees);
	}

		/**
	 * Fonction d'affichage du formulaire de modification
	 * @param $erreurs le message d'ereur
	 */
	public function afficheFormModification($erreurs = '')
	{
		// Récupére la liste des usagers
		$donnees['usager'] = $this->modele_usager->obtenir_tous();
		$donnees['usager'] = $this->modele_usager->obtenir_par_id($_GET['id']);
		$donnees['erreurs'] = $erreurs;
		// Afficher le formulaire du login
		$this->afficheVue('login/formulaire-modification', $donnees);
	}

	/**
	 * Fonction de validation du formulaire d'inscription
	 * @param $courriel, $nom, $prenom, $mdp ,$mdp2
	 * @return retourne le message d'erreur
	 */
	public function valideFormInscription($courriel, $nom, $prenom, $mdp ,$mdp2,$mdp3='')
	{
		// Initialiser le message d'erreur
		$msgErreur = '';

		// Récupérer le courriel
		$courriel = trim($courriel);
		// et le nom
		$nom = trim($nom);
		// et le prenom
		$prenom = trim($prenom);
		// et le premier mot de passe
		$mdp = trim($mdp);
		// et le deuxiéme mot de passe
		$mdp2 = trim($mdp2);
		
		if($courriel == '')
			$msgErreur .= 'Le champ Courriel est vide.<br>';
		
		if(!preg_match("/^[A-Z0-9.]+@(([A-Z]+\\.)+[A-Z]{2,6})$/i",$courriel))
			$msgErreur .= 'Le format courriel doit être réspecter.<br>';
		
		if($nom == '')
			$msgErreur .= 'Le nom ne peut être vide.<br>';

		if(!preg_match("/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{2,30})$/",$nom))
			$msgErreur .= 'Entrez au moins deux caractères.<br>';

		if($prenom == '')
			$msgErreur .= 'Le prénom ne peut être vide.<br>';

		if(!preg_match("/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{2,30})$/",$prenom))
			$msgErreur .= 'Entrez au moins deux caractères.<br>';

		if($mdp == '')
			$msgErreur .= 'Le mot de passe ne doit pas être vide.<br>';

		if(strlen($mdp)>12|| strlen($mdp)<5)
			$msgErreur .= 'Le mot de passe doit être entre 6 et 12 caractères.<br>';

		if($mdp != $mdp2)
			$msgErreur .= 'Les mots de passe doivent ètre identiques.<br>';

		// Retourner un message d'erreur
		return $msgErreur;
	}

		/**
	 * Fonction de validation du formulaire d'inscription
	 * @param $courriel, $nom, $prenom, $mdp ,$mdp2
	 * @return retourne le message d'erreur
	 */
	public function valideFormModification($courriel, $nom, $prenom, $mot_de_passe ,$mdp1,$mdp2)
	{
		// Initialiser le message d'erreur
		$msgErreur = '';

		// Récupérer le courriel
		$courriel = trim($courriel);
		// et le nom
		$nom = trim($nom);
		// et le prenom
		$prenom = trim($prenom);
		// et le premier mot de passe
		$mot_de_passe = trim($mot_de_passe);
		// et le deuxiéme mot de passe
		$mdp1 = trim($mdp1);
		// et le troisiemme mot de passe
		$mdp2 = trim($mdp2);
		
		if($courriel == '')
			$msgErreur .= 'Le champ Courriel est vide.<br>';
		
		if(!preg_match("/^[A-Z0-9.]+@(([A-Z]+\\.)+[A-Z]{2,6})$/i",$courriel))
			$msgErreur .= 'Le format courriel doit être réspecter.<br>';
		
		if($nom == '')
			$msgErreur .= 'Le nom ne peut être vide.<br>';

		if(!preg_match("/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{2,30})$/",$nom))
			$msgErreur .= 'Entrez au moins deux caractères.<br>';

		if($prenom == '')
			$msgErreur .= 'Le prénom ne peut être vide.<br>';

		if(!preg_match("/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{2,30})$/",$prenom))
			$msgErreur .= 'Entrez au moins deux caractères.<br>';

		if($mdp1 == '' || $mdp2 == '')
			$msgErreur .= 'Le mot de passe ne doit pas être vide.<br>';

		if(strlen($mdp1)>12|| strlen($mdp1)<5)
			$msgErreur .= 'Le mot de passe doit être entre 6 et 12 caractères.<br>';

		if(strlen($mdp2)>12|| strlen($mdp2)<5)
			$msgErreur .= 'Le mot de passe doit être entre 6 et 12 caractères.<br>';

		if($mdp1 != $mdp2)
			$msgErreur .= 'Les deux mots de passe doivent ètre identiques.<br>';

		// Retourner un message d'erreur
		return $msgErreur;
	}
}
