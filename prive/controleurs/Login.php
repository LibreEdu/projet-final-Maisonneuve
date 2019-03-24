<?php
/* Controleur login qui gére la connexion et l’inscription d’un usager*/
class Login extends Controleur
{
	protected $modele_usager;
	protected $modele_bouteille;

	public function __construct()
	{
		$this->modele_usager = $this->modele('modele_usager');
		$this->modele_bouteille = $this->modele('modele_bouteille');
	}

	public function traite(array $params)
	{
		switch($params['action'])
		{
			case 'index':
				$this->index();
			break;

			// Affichage du formulaire d’inscription
			case 'formulaire':
				$this->formulaire();
				break;

			// Gestion de l'inscription
			case ’sinscrire’:
				$this->’sinscrire’();
				break;

			case 'logout':
				$this->logout();
				break;

			default :
				trigger_error('Action invalide.');
		}
	}

	public function index()
	{
		$messageErreur = '';
		// Si on vient du formulaire
		if ( isset($_REQUEST['user']) && isset($_REQUEST['pass']) )
		{
			if($this->modele_usager->Authentification($_REQUEST['user'], $_REQUEST['pass']))
			{
				// Mets le nom d’usager dans la variable session UserID,
				// ce qui authentifie l’usager pour les pages protégées
				$_SESSION['UserID'] = $_REQUEST['user'];
				$user = $this->modele_usager->obtenirUsager($_REQUEST["user"]);
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
		if ( isset($_SESSION["admin"]) && $_SESSION["admin"] == true )
		{
			header('Location: ' . site_url('admin') );
		} elseif ( isset($_SESSION["idUsager"]) && $_SESSION["idUsager"] == true )
		{
			header('Location: ' .  site_url('cellier') );
		} else {
			$this->afficheVue('modeles/en-tete');
			$this->afficheVue('modeles/menu-login');
			$this->afficheVue('login/login');
			$this->afficheVue('modeles/bas-de-page');
		}
	}

	// Affichage du formulaire d'inscription
	public function formulaire()
	{
		$this->afficheVue('modeles/en-tete');
		$this->afficheVue('modeles/menu-login');
		$this->afficheVue('login/formulaire');
		$this->afficheVue('modeles/bas-de-page');
	}

	/*Gestion de l'inscription*/ 
	public function sinscrire()
	{
		$donnees["usager"] = $this->modele_usager->obtenir_tous();
		$donnees['bouteilles'] = $this->modele_bouteille->obtenir_tous();

		$messageErreur="";
		if(isset($_REQUEST['pseudo'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mdp'], $_REQUEST['mdp2'] ))
		{
			//Appel de la fonction valideFormInscription et verifier quesqu'elle retourne 
			$messageErreur = $this->valideFormInscription($_REQUEST['pseudo'], $_REQUEST['nom'], $_REQUEST['prenom'],$_REQUEST['mdp'], $_REQUEST['mdp2']);  

			if(($this->modele_usager->obtenirUsager($_REQUEST['pseudo'])))
			{//on vérifie que ce pseudo n'est pas déjà utilisé par un autre membre
				$messageErreur = ' Ce courriel est déjà utilisé.';
				$donnees['erreurs'] = $messageErreur;
			} 

			if($messageErreur == "")
			{// Procéder à l'insertion dans la table vino_usager
				$nouveauUsager = new Usager(0, 0, $params["pseudo"], $params["nom"], $params["prenom"], password_hash($params["mdp"], PASSWORD_DEFAULT) );

				$this->modele_usager->sauvegarde($nouveauUsager);
				//Affichage
				header( 'Location: ' . base_url() );
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
	}

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

	/*=====  Fonction d'affichage du formulaire d'ajout d'un usager  ======*/		
	public function afficheFormInscription($erreurs = '')
	{
		// Récupére la liste des usager
		$donnees['usager'] = $this->modele_usager->obtenir_tous();

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
