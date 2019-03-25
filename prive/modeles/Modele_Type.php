<?php
/**
 * Permet de gérer les types de vin.
 *
 * @package  Vino
 *.@author...José Ignacio Delgado
 * @author   Alexandre Pachot
 * @version  1.0
 */
class Modele_Type extends Modele
{
	public function getTableName()
	{
	/**
	 * Fonction qui retourne le nom de la table vino_type
	 * @return  le nom de la table
	 */
		return 'vino_type';
	}

	/**
	 * Fonction qui retourne la clé primaire du type
	 * @return la clé primaire
	 */
	public function getClePrimaire()
	{
		return 'id_type';
	}

	/**
	 * Fonction qui retourne tous les types
	 * @return $lesUsagers
	 */
	public function obtenir_tous()
	{
		$resultat = $this->lireTous();
		$lesTypes = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Type');
		return $lesTypes;
	}
}
