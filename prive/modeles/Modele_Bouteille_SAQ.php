<?php
/**
 * Permet de gérer les bouteilles de la SAQ.
 * 
 * @package  Vino 
 * @author   José Ignacio Delgado
 *.@author...Fatemeh Homatash
 * @author   Alexandre Pachot
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
	 * Retourne le résultat de la recherche pour la fonction d’autocomplete
	 * 
	 * @param string $nom La chaine de caractère à rechercher
	 * @param integer $nb_resultat Le nombre de résultat maximal à retourner.
	 * 
	 * @throws Exception Erreur de requête sur la base de données 
	 * 
	 * @return array tous les données de la bouteille trouvée dans le catalogue
	 */
	
	public function autocomplete($nom, $nb_resultat=10)
	{
		
		$listeBouteilles = Array();
		$nom = preg_replace('/\*/','%' , $nom);
		$sql ='SELECT * FROM vino_bouteille_saq where LOWER(nom) like LOWER("%' . $nom . '%") LIMIT 0,'. $nb_resultat;
		$requete = $this->requete($sql);
		$bouteilles = $requete->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Bouteille_SAQ');

		foreach($bouteilles as $bouteille) {
			$uneBouteille = array();
			$uneBouteille["id_bouteille_saq"] = $bouteille->id_bouteille_saq;
			$uneBouteille["code_saq"] = $bouteille->code_saq;
			$uneBouteille["prix"] = $bouteille->prix;
			$uneBouteille["millesime"] = $bouteille->millesime;
			$uneBouteille["id_type"] = $bouteille->id_type;
			$uneBouteille["pays"] = $bouteille->pays;
			$uneBouteille["format"] = $bouteille->format;
			$uneBouteille["nom"] = $bouteille->nom;
			array_push($listeBouteilles, $uneBouteille);
		}
		return $listeBouteilles;
	}

	public function recherche($id_cellier, $recherchePar, $valeur, $operation)
	{
		$listeBouteilles = Array();
		$valeur = preg_replace('/\*/','%' , $valeur);
		if ($recherchePar=='nom' ||  $recherchePar=='type' || $recherchePar=='pays') {
			$sql ='SELECT * FROM vino_bouteille where id_cellier=? AND LOWER('.$recherchePar.') like LOWER("%' .$valeur. '%")';
		}
		elseif ($recherchePar=='millesime' || $recherchePar=='prix' || $recherchePar=='quantite') {
			$sql ='SELECT * FROM vino_bouteille where id_cellier=? AND '.$recherchePar.$operation.$valeur;
		}
		$donnees=array($id_cellier);
		$requete = $this->requete($sql, $donnees);
		$bouteilles = $requete->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Bouteille_SAQ');
		foreach($bouteilles as $bouteille) {
			$uneBouteille = array();
			$uneBouteille["id_bouteille_saq"] = $bouteille->id_bouteille_saq;
			$uneBouteille["code_saq"] = $bouteille->code_saq;
			$uneBouteille["prix"] = $bouteille->prix;
			$uneBouteille["millesime"] = $bouteille->millesime;
			$uneBouteille["id_type"] = $bouteille->id_type;
			$uneBouteille["pays"] = $bouteille->pays;
			$uneBouteille["format"] = $bouteille->format;
			$uneBouteille["nom"] = $bouteille->nom;
			array_push($listeBouteilles, $uneBouteille);
		}
		return $listeBouteilles;
	}

	/**
	 * Fonction qui ajoute une liste d'achats
	 * @param 
	 * @return 
	 */
	public function ajouter_liste()
	{
		$sql = 'INSERT INTO vino_liste_achat (id_usager, nom) VALUES (?,?)';
		$donnees = array($_POST['id_usager'], $_POST['nom']);
		$resultat = $this->requete($sql, $donnees);
		$id= $this->bd->lastInsertId();
		//var_dump($id);die;
		$id_bouteille_saq = $_POST['id_bouteille_saq'];
		for($i=0; $i<count($id_bouteille_saq); $i++) {
			$sql2 = 'INSERT INTO vino_liste_affichage (id_liste_achat, id_bouteille_saq) VALUES (?,?)';
			$donnees2 = array($id, $id_bouteille_saq[$i]);
			$resultat2 = $this->requete($sql2, $donnees2);
		}
	}

	public function obtenir_liste($id_usager)
	{
		$sql = 'SELECT b.code_saq,
				b.prix,
				b.millesime,
				b.pays,
				b.format,
				b.nom,
				t.type
				FROM vino_bouteille_saq b
				INNER JOIN vino_type t
					ON b.id_type = t.id_type				
				INNER JOIN vino_liste_affichage a
					ON b.id_bouteille_saq = a.id_bouteille_saq
				INNER JOIN vino_liste_achat l
					ON id_usager =' . $id_usager . '
					AND l.id_liste_achat = a.id_liste_achat
				ORDER BY l.nom';
		$resultat = $this->requete($sql);
		$listes = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Bouteille_SAQ');

		return $listes;
	}

	public function obtenir_noms()
	{
		$sql = 'SELECT * FROM vino_liste_achat';
		$resultat = $this->requete($sql);
		$noms = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Bouteille_SAQ');

		return $noms;
	}
}