<?php
/**
 * Permet de gérer l'affichage des listes d'achat'.
 *
 * @package  Vino
 * @author   José Ignacio Delgado
 * @version  1.0
 */
class Modele_Affichage extends Modele
{
	public function getTableName()
	{
		return 'vino_liste_affichage';
	}

	public function getClePrimaire()
	{
		return 'id';
	}

	
	/**
	 * Retourne tous les id des listes d'achat et des bouteilles de la SAQ'
	 * 
	 * @return array Les données de la table affichage des listes d'achat.
	 */
	public function obtenir_tous()
	{
		$resultat = $this->lireTous();
		$listes = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Affichage');
		return $listes;
	}

	/**
	 * Retourne les données d’une liste d'acchat.
	 * @param integer $id_liste_achat Identifiants de la liste d'achat
	 * @return object Les données d’une liste d'achat.
	 */
	public function obtenir_par_id($id_liste_achat)
	{
		$resultat = $this->lire($id_liste_achat, 'id_liste_achat');
		$listes = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Affichage');

		return $listes;
	}	
}
