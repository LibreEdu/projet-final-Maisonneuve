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
	 * @return  $cellier Array des données du cellier.
	 */
	public function obtenir_par_id($id_cellier)
	{
		$resultat = $this->lire($id_cellier);
		$cellier = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'classe_cellier');
		return $cellier;
	}

	/**
	 * Récupère les donnes des celliers d’un usager.
	 * 
	 * @param integer $id_usager Identifiant de l’usager.
	 * 
	 * @return  $cellier Array des données des celliers de l’usager.
	 */
	public function obtenir_par_usager($id_usager)
	{
		$resultat = $this->lire($id_usager, 'id_usager');
		$cellier = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'classe_cellier');
		return $cellier;
	}

	/**
	 * Supprime cellier par id cellier dans la table vino_cellier
	 * 
	 * @param integer $id_cellier Indiquant le id de cellier qui est à supprimer
	 *
	 * @return boolean Indique si la requête a correctement fonctionné.
	 */
	public function supprimerCellier($id_cellier)
	{
		$resultat = $this->supprimer($id_cellier);
	}

	/**
	 * Fonction qui ajoute un cellier pour un usager
	 *
	 * @param integer $idUsager	Indiquant le id d'usager qui ajout un cellier
	 *
	 * @return boolean Indique si la requête a correctement fonctionné.
	 */
	public function ajouter($idUsager)
	{
		$sql = 'INSERT INTO vino_cellier (id_usager, nom) VALUES (?,?)';
		$donnees = array($idUsager, $_POST['nom']);
		$resultat = $this->requete($sql, $donnees);
	}

	/**
	 * Fonction qui verifie si bien le cellier appartient à un usager 
	 *
	 * @param integer $idCellier Indiquant le id de cellier 
	 * @param integer $idUsager Indiquant le id d'usager 
	 *
	 * @return mixed Le cellier trouvée dans la table vino cellier ou false
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
