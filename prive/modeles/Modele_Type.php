<?php
/**
 * Permet de gérer les types de vin.
 *
 * @package  Vino
 * @author   Alexandre Pachot
 * @version  1.0
 */
class Modele_Type extends Modele
{
	public function getTableName()
	{
		return 'vino_type';
	}

	public function getClePrimaire()
	{
		return 'id_type';
	}


	/**
	 * Retourne tous les types de bouteilles
	 * 
	 * @return array Les données de la table des types de bouteilles.
	 */
	public function obtenir_tous()
	{
		$resultat = $this->lireTous();
		$types = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'classe_type');
		return $types;
	}


	/**
	 * Vérifie l’existence du type
	 * 
	 * @return array Les données de la table des types de bouteilles.
	 */
	public function obtenir_type($type)
	{
		$resultat = $this->lire($type, 'type');
		$listes = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'classe_type');
		return $listes;
	}


	/**
	 * Ajoute un type de vin dans la table des types
	 * 
	 * @return integer L’identifiant du type que l’on vient d’insérer.
	 */
	public function ajouter_type($type)
	{
		$sql = 'INSERT INTO vino_type (type) VALUES (?)';
		$donnees = array($type);
		$this->requete($sql, $donnees);
		return $this->bd->lastInsertId();
	}

}
