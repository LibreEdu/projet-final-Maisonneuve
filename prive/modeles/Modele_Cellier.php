<?php
/**
 * Permet de gérer les celliers.
 *
 * @package  Vino 
 *.@author   Fatemeh Homatash
 *.@author   Charef Eddine Yagoubi
 * @version  1.0
 */
class Modele_Cellier extends Modele
{
	public function getTableName()
	{
		return 'vino_cellier';
	}

	public function getClePrimaire()
	{
		return 'id_cellier';
	}

	/**
	 * Récupère les donnes d’un cellier.
	 * 
	 * @param integer $id_cellier Identifiant du cellier.
	 * 
	 * @return array Les données du cellier.
	 */
	public function obtenir_par_id($id_cellier)
	{
		$resultat = $this->lire($id_cellier);
		$cellier = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Cellier');
		return $cellier;
	}

	/**
	 * Récupère les donnes des celliers d’un usager.
	 * 
	 * @param integer $id_usager Identifiant de l’usager.
	 * 
	 * @return array Les données des celliers de l’usager.
	 */
	public function obtenir_par_usager($id_usager)
	{
		$resultat = $this->lire($id_usager, 'id_usager');
		$cellier = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Cellier');
		return $cellier;
	}

	/**
	 * Supprime un cellier
	 * 
	 * @param integer $id_cellier
	 * 
	 * À VÉRIFIER, CE QUE LA FONCTION RETOURNE
	 * @return boolean Indique si la requête a correctement fonctionné.
	 */
	public function supprimer_par_id($id_cellier)
	{
		$resultat = $this->supprimer($id_cellier);
		return $resultat;
		//$sql = 'DELETE FROM vino_bouteille WHERE (id_cellier) VALUES (?)';
		//$sql += 'DELETE FROM vino_cellier WHERE (id_cellier) VALUES (?)';
		//$donnees = array($_POST['id_cellier']);
		//$resultat = $this->requete($sql, $donnees);
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
