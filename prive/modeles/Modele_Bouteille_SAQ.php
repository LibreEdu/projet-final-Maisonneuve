<?php
/**
 * Permet de gérer les bouteilles de la SAQ.
 * 
 * @package  Vino 
 * @author   José Ignacio Delgado
 *.@author...Fatemeh Homatash
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
		$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Total');
		$nbBouteilles = $resultat->fetch();
		return $nbBouteilles->total;
	}
}
