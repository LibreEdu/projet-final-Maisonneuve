<?php
/**
 * Permet de gérer les bouteilles de la SAQ.
 * 
 * @package  Vino 
 * @author   José Ignacio Delgado
 *.@author   Fatemeh Homatash
 * @version  1.0
 */
class Modele_Bouteille_SAQ extends Modele
{
	public function getTableName()
	{
		return 'vino_bouteille_saq';
	}


	public function getClePrimaire()
	{
		return 'id_bouteille_saq';
	}


	/**
	 * Retourne le nombre d’enregistrements de la table.
	 * 
	 * @return string Le nombre d’enregistrements de la table.
	 */
	public function obtenir_total()
	{
		$resultat = $this->total();
		$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'classe_total');
		$nbBouteilles = $resultat->fetch();
		return $nbBouteilles->total;
	}


	/**
	 * Vérifie si une bouteille est présente.
	 * 
	 * @param string $code_SAQ Le code SAQ de la bouteille recherchée.
	 * 
	 * @return array Un tableau d’éléments contenant les bouteilles correspondant au code SAQ. Ce tableau est sensé de contenir un seul élément.
	 */
	public function estPresent($code_saq)
	{
		$resultat = $this->lire($code_saq, 'code_saq');
		$bouteilles = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'classe_bouteille_saq');
		return $bouteilles;
	}


	/**
	 * Insère une bouteille dans la table.
	 * 
	 * @param object $bouteille Un object de la classe Classe_Bouteille_SAQ.
	 * 
	 * @return object PDOStatement
	 */
	public function inserer($bouteille)
	{
		$sql = 'INSERT INTO vino_bouteille_saq (code_saq, prix, millesime, id_type, pays, format, nom) VALUES (?,?,?,?,?,?,?)';
		$donnees = array($bouteille->code_saq, $bouteille->prix, $bouteille->millesime, $bouteille->id_type, $bouteille->pays, $bouteille->format, $bouteille->nom);
		return $this->requete($sql, $donnees);
	}


	/**
	 * Met à jour une bouteille de la table.
	 * 
	 * @return object PDOStatement
	 */
	public function mettreAJour($bouteille)
	{
		$sql = 'UPDATE vino_bouteille_saq SET prix = ?, millesime = ?, id_type = ?, pays = ?, format = ?, nom = ? WHERE code_saq = ?';
		$donnees = array($bouteille->prix, $bouteille->millesime, $bouteille->id_type, $bouteille->pays, $bouteille->format, $bouteille->nom, $bouteille->code_saq);
		return $this->requete($sql, $donnees);
	}
}