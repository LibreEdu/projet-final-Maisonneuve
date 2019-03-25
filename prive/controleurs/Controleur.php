<?php

/**
 * Modèle pour les contrôleurs.
 *
 * @package  Vino
 * @author   Guillaume Harvey
 * @author   Alexandre Pachot
 * @version  1.0
 */
abstract class Controleur
{
	// La fonction qui sera appelée par le routeur
	public abstract function traite(array $params);
	
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

	protected function modele($nomModele)
	{
		if(class_exists($nomModele))
		{
			// On fait une connexion à la BD
			$connexion = BaseDeDonnees::obtenirBD(DBTYPE, HOST, DBNAME, CHARSET, USER, PWD);
			
			// On crée une instance de la classe Modele_$classe
			$objetModele = new $nomModele($connexion);

			if($objetModele instanceof Modele)
			{
				return $objetModele;
			}
			else
			{
				trigger_error('Modèle invalide.');
			}
		}
		else
		{
			trigger_error('Le modèle $nomModele est invalide.');
		}
	}
}
