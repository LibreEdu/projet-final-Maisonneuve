<?php
/**
 * Permet de gérer les celliers.
 *
 * @package  Vino 
 * @author   José Ignacio Delgado
 *.@author...Fatemeh Homatash
 * @author   Alexandre Pachot
 *.@author...Charef Eddine Yagoubi
 * @version  1.0
 */
class Modele_Cellier extends Modele
{
	/**
	 * Fonction qui retourne le nom de la table vino_cellier
	 * @return  le nom de la table
	 */
	public function getTableName()
	{
		return 'vino_cellier';
	}

	/**
	 * Fonction qui retourne la clé primaire du cellier
	 * @return la clé primaire
	 */
	public function getClePrimaire()
	{
		return 'id_cellier';
	}

	/**
	 * Fonction qui retourne le cellier par son id
	 * @param $id_cellier
	 * @return $monCellier
	 */
	public function obtenir_par_id($id_cellier)
	{
		$resultat = $this->lire($id_cellier);
		$monCellier = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Cellier');
		return $monCellier;
	}

	/**
	 * Fonction qui retourne le cellier par son usafer
	 * @param $id_usager
	 * @return $monCellier
	 */
	public function obtenir_par_usager($id_usager)
	{
		$resultat = $this->lire($id_usager, 'id_usager');
		$monCellier = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Cellier');
		return $monCellier;
	}

	/**
	 * Fonction qui supprime le cellier par son id
	 * @param $id
	 * @return $resultat
	 */
	public function supprimer_par_id($id)
	{
		$resultat = $this->supprimer($id);
		return $resultat;
	}

	/**
	 * Fonction qui ajoute un cellier pour un usager
	 * @param $idUsager	
	 */
	public function ajouter($idUsager)
	{
		$sql = 'INSERT INTO vino_cellier (id_usager, nom) VALUES (?,?)';
		$donnees = array($idUsager, $_POST['nom']);
		$resultat = $this->requete($sql, $donnees);
	}

	/**
	 * Fonction qui verifie si bien le cellier appartient à un usager 
	 * @param $idCellier
	 * @param $idUsager
	 * @return $resultat
	 */
	public function verif_usager($idCellier, $idUsager)
	{
		$sql = 'SELECT id_cellier FROM vino_cellier WHERE id_cellier = ? AND id_usager = ?';
		$donnees = array($idCellier,$idUsager);
		
		$resultat = $this->requete($sql,$donnees);
		// Récupère le résultat sous forme d’un objet
		$result = $resultat->fetch(PDO::FETCH_OBJ);
		return $result;
	}	
}
