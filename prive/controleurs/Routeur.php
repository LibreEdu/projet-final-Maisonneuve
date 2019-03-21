<?php
	// Ouverture de la session
	session_start();

	class Routeur
	{
		public static function route()
		{
			// Récupére la chaine de caractères de l’URL ou des données du formulaire
			$chaineRequete = $_SERVER['QUERY_STRING'];

			// Cherche la position de la première occurrence de & dans la chaine de caractères
			$posEperluette = strpos($chaineRequete, '&');

			// Initialise le controleur
			$controleur = '';

			// Récupère le controleur
			if($posEperluette === false)
				$controleur = $chaineRequete;
			else
				$controleur = substr($chaineRequete, 0, $posEperluette);

			// Si aucun contrôleur n’est spécifié, mettre le contrôleur par défaut
			if($controleur == '')
				$controleur = 'uBouteille';

			// Détermin la classe du controleur
			$classe = 'Controleur_' . $controleur;

			// Si la classe existe
			if(class_exists($classe))
			{
				// Crée une nouvelle instance de la classe
				$objetControleur = new $classe;

				// Si l’objet est instancié d’une classe qui hérite de BaseControleur
				if($objetControleur instanceof BaseControleur)
				{
					// Traite la requête
					$objetControleur->traite($_REQUEST);
				}
				else
					trigger_error('Controleur invalide.');
			}
			else
			{
				trigger_error('Erreur 404! Le controleur $controleur n’existe pas.');
			}
		}
	}
