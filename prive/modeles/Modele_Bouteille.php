<?php
/**
 * Permet de gérer les bouteilles des usagers.
 *
 * @package  Vino 
 * @author   José Ignacio Delgado
 *.@author...Fatemeh Homatash
 * @author   Alexandre Pachot
 * @version  1.0
 */
class Modele_Bouteille extends Modele
{
	public function getTableName()
	{
		return 'vino_bouteille';
	}

	public function getClePrimaire()
	{
		return 'id_bouteille';
	}

	/**
	 * Fonction qui retourne la bouteille par son id
	 * @param $id
	 * @return $maBouteille
	 */
	public function obtenir_par_id($id)
	{
		$resultat = $this->lire($id, 'id_bouteille');
		$maBouteille = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Bouteille');
		return $maBouteille;
	}

	/**
	 * Cette méthode récupére les details des bouteilles en montrant le type a la place de id de type
	 * 
	 * @param int $id id cellier_bouteille 
	 * 
	 * @return $laBouteille details des bouteilles ainsi que le type de bouteille.
	 */
	public function obtenir_par_id_t($idCellier)
	{			
		//Requete de tous les details des bouteilles
		$requete = "SELECT b.id_bouteille,
					b.id_cellier,
					b.code_saq,
					b.prix,
					b.millesime,
					b.pays,
					b.format,
					b.nom,
					b.note,
					b.quantite,
					b.date_achat,
					b.boire_avant,
					t.type
					FROM vino_bouteille b
					INNER JOIN vino_type t
					ON b.id_type = t.id_type
					WHERE id_cellier = ?
					ORDER BY id_bouteille";
		$donnees = array($idCellier);
		$resultat = $this->requete($requete, $donnees);
		$laBouteille = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Bouteille');			
		return $laBouteille;    
	}

	/**
	 * Cette méthode change la quantité d’une bouteille en particulier dans le cellier
	 * 
	 * @param int $id id de la bouteille
	 * @param int $nombre Nombre de bouteille à ajouter ou à retirer
	 * 
	 * @return Boolean Succès ou échec de l’ajout.
	 */
	public function modifierQuantite($id, $nombre)
	{
		//TODO : Valider les données.
			
			
		$requete = 'UPDATE vino_bouteille SET quantite = GREATEST(quantite + '. $nombre. ', 0) WHERE id_bouteille = '. $id;
		//echo $requete;
		$res = $this->requete($requete);
		// var_dump($res);
		// die();
		
		return $res;
	}

	/**
	 * Cette méthode récupére la quantité d’une bouteille en particulier dans le cellier
	 * 
	 * @param int $id id  cellier_bouteille 
	 * 
	 * @return $laBouteille la ligne de la quantité de la bouteille en question.
	 */
	public function recupererQuantiteBouteilleCellier($id)
	{
		
		//Requete qui récupére la quantité d’une bouteille en particulier
		$requete = 'SELECT quantite FROM vino_bouteille WHERE id_bouteille = '. $id;
		$resultat = $this->requete($requete);

		$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Bouteille');
		$laBouteille = $resultat->fetchALL();
		return $laBouteille;    
	}

	/**
	 * Fonction qui modifie la bouteille
	 * @param 
	 * @return 
	 */
	public function modifier()
	{
		$sql = 'UPDATE vino_bouteille 
			SET date_achat=?,
				quantite=?,
				prix=?,
				millesime=?,
				boire_avant=?,
				nom=?,
				pays=?,
				format=?,
				note=?,
				id_type=?,
				id_cellier=?
			WHERE id_bouteille=?';

		$donnees = array($_POST['date_achat'], $_POST['quantite'], $_POST['prix'], $_POST['millesime'], $_POST['boire_avant'], $_POST['nom'], $_POST['pays'], $_POST['format'], $_POST['note'], $_POST['type'], $_POST['id_cellier'], $_POST['id_bouteille']);

		$resultat = $this->requete($sql, $donnees);
	}

	/**
	 * Fonction qui ajoute une bouteille
	 * @param 
	 * @return 
	 */
	public function ajouter()
	{
		$sql = 'INSERT INTO vino_bouteille (date_achat, quantite, prix, millesime, boire_avant, nom, pays, format, note, id_type, id_cellier) VALUES (?,?,?,?,?,?,?,?,?,?,?)';
		$donnees = array($_POST['date_achat'], $_POST['quantite'], $_POST['prix'], $_POST['millesime'], $_POST['boire_avant'], $_POST['nom'], $_POST['pays'], $_POST['format'], $_POST['note'], $_POST['type'], $_POST['id_cellier']);
		$resultat = $this->requete($sql, $donnees);
	}

	/**
	 * Fonction qui retourne la bouteille par rapport à un usager
	 * @param $idBouteille
	  * @param $idUsager
	 * @return $result;
	 */
	public function appartient($idBouteille, $idUsager)
	{
		$sql = 'SELECT id_bouteille FROM vino_bouteille bouteille
		INNER JOIN vino_cellier cellier
			ON bouteille.id_cellier = cellier.id_cellier
		WHERE id_bouteille = ? 
		AND id_usager = ?';

		$donnees = array($idBouteille,$idUsager);
		
		$resultat = $this->requete($sql,$donnees);
		// Récupère le résultat sous forme d’un objet
		$result = $resultat->fetch(PDO::FETCH_OBJ);
		return $result;
	}
}
