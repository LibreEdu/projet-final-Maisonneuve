<?php
/**
 * Permet de gérer les bouteilles des usagers.
 *
 * @package  Vino 
 * @author   Fatemeh Homatash
 * @author   José Ignacio Delgado
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
	 * Retourne les données d’une bouteille.
	 * @param integer $id_bouteille Identifiants de la bouteille
	 * @return object Les données d’une bouteille.
	 */
	public function obtenir_par_id($id_bouteille)
	{
		$resultat = $this->lire($id_bouteille, 'id_bouteille');
		$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Bouteille');
		return $resultat->fetch();
	}

	/**
	 * Récupère les données des bouteilles d’un cellier.
	 * 
	 * @param integer $id_cellier Identifiant du cellier.
	 * 
	 * @return array Les données des bouteilles d’un cellier.
	 */
	public function bouteilles_cellier($id_cellier)
	{
		//Requete de tous les details des bouteilles
		$sql = 'SELECT b.id_bouteille,
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
			ORDER BY id_bouteille';
		$donnees = array($id_cellier);
		$resultat = $this->requete($sql, $donnees);
		$bouteilles = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Bouteille');
		return $bouteilles;
	}

	/**
	 * Change la quantité de bouteilles.
	 * 
	 * @param integer $id_bouteille Identifiant de la bouteille.
	 * @param integer $delta Nombre de bouteille à ajouter ou à retirer
	 * 
	 * @return mixed Jeu de résultat si la requête a été correctement exécutée, false sinon.
	 */
	public function modifier_quantite($id_bouteille, $delta)
	{
		$sql = 'UPDATE vino_bouteille SET quantite = GREATEST(quantite + ?, 0) WHERE id_bouteille = ?' ;
		$donnees = array($delta, $id_bouteille);
		$resultat = $this->requete($sql, $donnees);		
		return $resultat;
	}

	/**
	 * Récupère la quantité de bouteilles.
	 * 
	 * @param integer $id_bouteille Identifiant de la bouteille.
	 * 
	 * @return object Les données d’une bouteille.
	 */
	public function recuperer_quantite($id_bouteille)
	{
		//Requete qui récupére la quantité d’une bouteille en particulier
		$sql = 'SELECT quantite FROM vino_bouteille WHERE id_bouteille = ? ';
		$donnees = array($id_bouteille);
		$resultat = $this->requete($sql, $donnees);
		$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Bouteille');
		return $resultat->fetch();
	}

	/**
	 * Supprime bouteille par id cellier dans la table vino_bouteille
	 * 
	 * @param integer $id_cellier
	 * 
	 * À VÉRIFIER, CE QUE LA FONCTION RETOURNE
	 * @return boolean Indique si la requête a correctement fonctionné.
	 */
	public function supprimerBouteille($id_cellier)
	{
		$resultat = $this->supprimer($id_cellier, 'id_cellier');
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
		$sql = 'INSERT INTO vino_bouteille (date_achat, quantite, prix, millesime, boire_avant, nom, pays, format, note, id_type, id_cellier, code_saq) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
		$donnees = array($_POST['date_achat'], $_POST['quantite'], $_POST['prix'], $_POST['millesime'], $_POST['boire_avant'], $_POST['nom'], $_POST['pays'], $_POST['format'], $_POST['note'], $_POST['type'], $_POST['id_cellier'], $_POST['code_saq']);
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

	/**
	 * Retourne la liste de bouteilles qui ont été trouvé
	 * 
	 * @param integer $id_cellier identifiant du cellier.
	 * @param string $rechercherPar Levariable a rechercher.
	 * @param mixed $valeur Le valeur à rechercher.
	 * @param string $operation Le type d'operation qui est choisit.
	 * 
	 * @throws Exception Erreur de requête sur la base de données. 
	 * 
	 * @return Array tous les données de la bouteille trouvée. 
	 */
	public function recherche($id_cellier, $recherchePar, $valeur, $operation)
	{
		$listeBouteilles = Array();	
		$valeur = preg_replace('/\*/','%' , $valeur);
		if ($recherchePar=='nom' ||  $recherchePar=='type' || $recherchePar=='pays') {
			$sql ='SELECT * FROM vino_bouteille INNER JOIN vino_type t ON vino_bouteille.id_type = t.id_type 
			where id_cellier=? AND LOWER('.$recherchePar.') like LOWER("%' .$valeur. '%")';
		}
		elseif ($recherchePar=='millesime' || $recherchePar=='prix' || $recherchePar=='quantite') {
			$sql ='SELECT * FROM vino_bouteille INNER JOIN vino_type t ON vino_bouteille.id_type = t.id_type 
			where id_cellier=? AND '.$recherchePar.$operation.$valeur;
		}
		$donnees=array($id_cellier);
		$requete = $this->requete($sql, $donnees);
		$bouteilles = $requete->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Bouteille');
		
		if ($bouteilles == NULL) {
			return 0;
		}
		else{
			foreach($bouteilles as $bouteille) {
				$uneBouteille = array();
				$uneBouteille["id_bouteille"] = $bouteille->id_bouteille;
				$uneBouteille["nom"] = $bouteille->nom;
				$uneBouteille["code_saq"] = $bouteille->code_saq;
				$uneBouteille["prix"] = $bouteille->prix;
				$uneBouteille["millesime"] = $bouteille->millesime;
				$uneBouteille["type"] = $bouteille->type;
				$uneBouteille["pays"] = $bouteille->pays;
				$uneBouteille["format"] = $bouteille->format;
				$uneBouteille["quantite"] = $bouteille->quantite;
				$uneBouteille["date_achat"] = $bouteille->date_achat;
				$uneBouteille["boire_avant"] = $bouteille->boire_avant;
				array_push($listeBouteilles, $uneBouteille);
			}
			return $listeBouteilles;
		}
	}
}
