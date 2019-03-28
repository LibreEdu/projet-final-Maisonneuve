<?php
/**
 * Permet de gérer les types de vin.
 *
 * @package  Vino
 *.@author...José Ignacio Delgado
 * @author   Alexandre Pachot
 *.@author...Fatemeh Homatash
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
