<?php

/**
 * Classe parente des contrôleurs.
 *
 * @package  Vino
 * @author   Guillaume Harvey
 * @author   Alexandre Pachot
 * @version  1.0
 */
abstract class Controleur
{
	/**
	 * Traite la requête du contrôleur.
	 * 
	 * Lorsque le routeur a trouvé le contrôleur demandé, il appelle la méthode traite() du contrôleur. Cette méthode est la porte d’entrée de toutes les requêtes du contrôleur.
	 * 
	 * @param array $params Variables de la requête HTTP ($_REQUEST).
	 * 
	 * @return void
	 */
	public abstract function traite(array $params);
	

	/**
	 * Affiche la vue demandée.
	 * 
	 * @param string $nomVue Chemin et nom de la vue demandée.
	 * @param array $donnees Tableau contenant l’ensemble des données qui seront appelées par la vue.
	 * 
	 * @return void
	 */
	protected function afficheVue($nomVue, $donnees = null)
	{
		$cheminVue = RACINE . 'vues/' . $nomVue . '.php';
		
		if(file_exists($cheminVue))
		{
			include_once($cheminVue);
		}
		else
		{
			trigger_error('Erreur 404! La vue $nomVue n’existe pas.');
		}
	}


	/**
	 * Établit une connexion à la base de données et charge le modèle demandé. 
	 * 
	 * @param string $nomModele Nom de la classe du modèle demandé (non sensible à la casse).
	 * 
	 * @return object Une instance du modèle demandée.
	 */
	protected function modele($nomModele)
	{
		if(class_exists($nomModele))
		{
			// On fait une connexion à la BD
			$connexion = BaseDeDonnees::obtenirBD(DBTYPE, HOST, DBNAME, CHARSET, USERNAME, PASSWD);
			
			// On crée une instance de la classe Modele_$classe
			$objetModele = new $nomModele($connexion);

			if($objetModele instanceof Modele)
			{
				return $objetModele;
			}
			else
			{
				trigger_error("Modèle $nomModele invalide.");
			}
		}
		else
		{
			trigger_error("Le modèle $nomModele est invalide.");
		}
	}
}
