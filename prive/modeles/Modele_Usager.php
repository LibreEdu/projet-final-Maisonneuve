<?php
/**
 * Permet de gérer les utilisateurs.
 *
 * @package  Vino 
 * @author   Charef Eddine Yagoubi
 * @author   Alexandre Pachot
 * @version  1.0
 */
class Modele_Usager extends Modele
{
	public function getTableName()
	{
		return 'vino_usager';
	}

	public function getClePrimaire()
	{
		return 'id_usager';
	}


	/**
	 * Retourne les données de tous les usagers.
	 * 
	 * @return array Les données de tous les usagers.
	 */
	public function obtenir_tous()
	{
		$resultat = $this->lireTous();
		$usagers = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'classe_usager');
		return $usagers;
	}


	/**
	 * Vérifie l’exactitude du mot de passe.
	 * 
	 * @param string $courriel Le courriel de l’usager.
	 * @param string $mot_de_passe Le mot de passe de l’usager.
	 * 
	 * @return boolean Vrai si c’est le bon usager avec le bon mot de passe, sinon faux.
	 */
	public function Authentification($courriel, $mot_de_passe)
	{
		$resultat = $this->lire($courriel, 'courriel');
		$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'classe_usager');
		$usager = $resultat->fetch();
		
		if($usager)
		{
			if(password_verify($mot_de_passe, $usager->mot_de_passe))
				// C’est le bon mot de passe
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
	 * Retourne les données de l’usager.
	 * 
	 * @param integer $id L’identifiant de l’usager.
	 * 
	 * @return array Les données de l’usager.
	 */
	public function obtenirUsager($id)
	{
		$resultat = $this->lire($id, 'courriel');
		$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'classe_usager');
		return $resultat->fetch();
	}


	/**
	 * Insère les données de l’usager dans la base de données.
	 * 
	 * @param object $usager Une instance de la classe Classe_Usager
	 * 
	 * @return mixed Jeu de résultat si la requête a été correctement exécutée, false sinon.
	 */
	public function inscrire(Classe_Usager $usager)
	{
		$sql = 'INSERT INTO vino_usager (courriel, admin, nom, prenom, mot_de_passe) VALUES (?, ?, ?, ?, ?)';
		$donnees = array($usager->courriel, $usager->admin, $usager->nom, $usager->prenom, $usager->mot_de_passe);

		return $this->requete($sql, $donnees);
	}


	/**
	 * Retourne les données de l’usager.
	 * 
	 * @param integer $id Identifiant de l’usager.
	 * 
	 * @return array Les données de l’usager.
	 */
	public function obtenir_par_id($id)
	{
		$resultat = $this->lire($id, 'id_usager');
		$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'classe_usager');

		return $resultat->fetch();
	}


	/**
	 * Modifie les données de l’usager.
	 * 
	 * @return mixed Jeu de résultat si la requête a été correctement exécutée, false sinon.
	 */
	public function modifier()
	{
		$sql = 'UPDATE vino_usager 
			SET courriel=?,
				nom=?,
				prenom=?,
				mot_de_passe=?
			WHERE id_usager=?';
			
		$donnees = array($_POST['courriel'], $_POST['nom'], $_POST['prenom'], password_hash($_POST['mdp2'], PASSWORD_DEFAULT),$_POST['id_usager']);

		$resultat = $this->requete($sql, $donnees);
		// }
	// }
}
	/**
	 * Modifie les données de l’usager.
	 * 
	 * @return mixed Jeu de résultat si la requête a été correctement exécutée, false sinon.
	 */
	public function modifierSansMotDePasse()
	{
		$sql = 'UPDATE vino_usager 
			SET courriel=?,
				nom=?,
				prenom=?
			WHERE id_usager=?';
			
		$donnees = array($_POST['courriel'], $_POST['nom'], $_POST['prenom'],$_POST['id_usager']);

		$resultat = $this->requete($sql, $donnees);
	}
}