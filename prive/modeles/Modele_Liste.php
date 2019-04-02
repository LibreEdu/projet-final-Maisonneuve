<?php
/**
 * Permet de gérer les listes d'achat'.
 *
 * @package  Vino
 * @author   José Ignacio Delgado
 * @version  1.0
 */
class Modele_Liste extends Modele
{
	public function getTableName()
	{
		return 'vino_liste_achat';
	}

	public function getClePrimaire()
	{
		return 'id_liste_achat';
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

	/**
	 * Fonction qui ajoute une liste d'achats
	 * @param 
	 * @return 
	 */
	public function ajouter_liste()
	{
		try
		{
			$sql = 'INSERT INTO vino_liste_achat (id_usager, nom) VALUES (?,?)';
			$donnees = array($_POST['id_usager'], $_POST['nom']);
			$resultat = $this->requete($sql, $donnees);
			$id= $this->bd->lastInsertId();
			
			$id_bouteille_saq = $_POST['id_bouteille_saq'];
			for($i=0; $i<count($id_bouteille_saq); $i++) {
				$sql2 = 'INSERT INTO vino_liste_affichage (id_liste_achat, id_bouteille_saq) VALUES (?,?)';
				$donnees2 = array($id, $id_bouteille_saq[$i]);
				$resultat2 = $this->requete($sql2, $donnees2);
			}
			echo '<script>alert("La liste a été créée.")</script>';
		}
		catch(PDOException $e)
		{
			trigger_error("<p>La requête suivante a donné une erreur : $sql</p><p>Exception : " . $e->getMessage() . '</p>');
			return false;
		}
	}

	/**
	 * Retourne le résultat de la recherche pour la fonction d’autocomplete
	 * 
	 * @param integer $id_usager L'i de l'usager connecté.
	 * 
	 * @return array tous les données de la bouteille dans la table bouteille SAQ
	 */
	public function obtenir_liste($id_usager, $nom_liste_achat)
	{
		$sql = 'SELECT b.code_saq,
				b.prix,
				b.millesime,
				b.pays,
				b.format,
				b.nom,
				a.id_liste_achat,
				t.type,
				l.nom as nom_liste
				FROM vino_bouteille_saq b
				INNER JOIN vino_type t
					ON b.id_type = t.id_type				
				INNER JOIN vino_liste_affichage a
					ON b.id_bouteille_saq = a.id_bouteille_saq
				INNER JOIN vino_liste_achat l
					ON id_usager =' . $id_usager . '
					AND l.nom ="' . $nom_liste_achat . '"
					AND l.id_liste_achat = a.id_liste_achat
				ORDER BY l.nom';
		$resultat = $this->requete($sql);
		$listes = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_bouteille_SAQ');

		return $listes;
	}

	/**
	 * Retourne tous les listes d'achat'
	 * 
	 * @return array Les données de la table des listes d'achat.
	 */
	public function obtenir_tous()
	{
		$resultat = $this->lireTous();
		$listes = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Liste');
		return $listes;
	}

	public function supprimer_bouteille($id_liste_achat)
	{
		$resultat = $this->supprimer($id_liste_achat, 'id_liste_achat');
		$resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe_Liste');
		return $resultat->fetch();
	}
}
