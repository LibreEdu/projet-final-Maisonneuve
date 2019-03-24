<?php
class Modele_Cellier extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function ajoutCellier($idUsager)
	{
		$sql = 'INSERT INTO vino_cellier (id_usager, nom) VALUES (?,?)';
		$donnees = array($idUsager, $_POST['nom']);
		$resultat = $this->requete($sql, $donnees);
	}	

	public function verifParUsager($idCellier,$idUsager)
	{
		$sql = 'SELECT id_cellier FROM vino_cellier WHERE id_cellier = ? AND id_usager = ?';
		$donnees = array($idCellier,$idUsager);
		
		$resultat = $this->requete($sql,$donnees);
		// Récupère le résultat sous forme d’un objet
		$result = $resultat->fetch(PDO::FETCH_OBJ);
		return $result;
	}	
}
