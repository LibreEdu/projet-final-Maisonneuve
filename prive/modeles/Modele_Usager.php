<?php
/**
 * Modele_Usager permet de gérer les utilisateurs.
 * @package  Vino 
 * @author   Alexandre Pachot
 *.@author...Charef Eddine Yagoubi
 * @version  1.0
 */
class Modele_Usager extends Modele
{
	/**
	 * Fonction qui retourne le nom de la table usager
	 * @return  le nom de la table
	 */
	public function getTableName()
	{
		return 'vino_usager';
	}

	/**
	 * Fonction qui retourne la clé primaire de l'usager
	 * @return la clé primaire
	 */
	public function getClePrimaire()
	{
		return 'id_usager';
	}

	/**
	 * Fonction qui retourne tous les usagers
	 * @return $lesUsagers
	 */
	public function obtenir_tous()
	{
		$resultat = $this->lireTous();
		$lesUsagers = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Usager');
		return $lesUsagers;
	}

	/**
	 * Fonction qui authentifie un utilisateur et qui retourne un 
	 * booléen
	 * @param string $username l’username de l’usager
	 * @param string $password le mot de passe de l’usager
	 * @return  boolean 
	 */
	public function Authentification($courriel, $mot_de_passe)
	{
		$resultat = $this->lire($courriel, 'courriel');
		$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Usager');
		$usager = $resultat->fetch();
		
		if($usager)
		{
			if(password_verify($mot_de_passe, $usager->mot_de_passe))
				return true;
			else
			{
				// Ce n’est pas le bon mot de passe
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * Fonction qui retourne le nom de l’usager courriel par son id
	 * @param integer $id l’id de l’usager
	 * @param string $colonne le courriel de l’usager
	 * @return $lUsager
	 */
	public function obtenirUsager($id, $colonne = 'courriel')
	{
		$resultat = $this->lire($id, $colonne);
		$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Usager');
		$lUsager = $resultat->fetch();
		return $lUsager;
	}

	/**
	 * Fonction qui insére un usager dans la table vino_usager id
	 * @param usager
	 * @return 
	 */
	public function inscrire(Usager $usager)
	{
		$query = 'INSERT INTO vino_usager (courriel, admin, nom, prenom, mot_de_passe) VALUES (?, ?, ?, ?, ?)';
		$donnees = array($usager->courriel, $usager->admin, $usager->nom, $usager->prenom, $usager->mot_de_passe);
		return $this->requete($query, $donnees);
	}
}
