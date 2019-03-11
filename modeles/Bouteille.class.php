<?php
/**
 * Class Bouteille
 * Cette classe possède les fonctions de gestion des bouteilles dans le cellier et des bouteilles dans le catalogue complet.
 * 
 * @author Jonathan Martel
 * @author Alexandre Pachot
 * @version 1.0
 * @update 2019-03-10
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */
class Bouteille extends Modele {
	const TABLE = 'vino_bouteille';
	
	public function getListeBouteille()
	{
		
		$lignes = Array();
		$res = $this->_db->query('Select * from '. self::TABLE);
		if($res->num_rows)
		{
			while($row = $res->fetch_assoc())
			{
				$lignes[] = $row;
			}
		}
		
		return $lignes;
	}
	
	public function obtenir_liste_bouteilles_cellier($id_cellier)
	{
		$liste_bouteilles_cellier = array();
		$requete ='SELECT cb.id AS id_cellier_bouteille,
				cb.date_achat AS date_achat,
				cb.quantite AS quantite,
				cellier.libelle AS nom_cellier,
				bouteille.id AS id_bouteille,
				bouteille.libelle AS nom,
				bouteille.code_saq AS code_SAQ,
				bouteille.date_buvable AS date_buvable,
				bouteille.prix AS prix,
				bouteille.millesime AS millesime,
				bouteille.pays AS pays,
				bouteille.format AS format,
				bouteille.note AS note,
				type.libelle AS type
			FROM vino_cellier__bouteille cb
			INNER JOIN vino_cellier cellier
				ON cellier.id = cb.id_cellier
			INNER JOIN vino_cellier__usager cu
				ON cu.id_cellier = cellier.id
			INNER JOIN vino_usager usager
				ON usager.id = cu.id_usager
			INNER JOIN vino_bouteille bouteille 
				ON bouteille.id = cb.id_bouteille
			LEFT JOIN vino_type type
				ON type.id = bouteille.id_type
			WHERE cu.id_role = 1
				AND cellier.id = ' . $id_cellier . '
			ORDER BY bouteille.libelle';
	
		if(($resultat = $this->_db->query($requete)) ==	 true)
		{
			if($resultat->num_rows)
			{
				while($ligne_resultat = $resultat->fetch_assoc())
				{
					$liste_bouteilles_cellier[] = $ligne_resultat;
				}
			}
		}
		else 
		{
			throw new Exception("Erreur de requête sur la base de donnée", 1);
		}
		
		return $liste_bouteilles_cellier;
	}
	
	/**
	 * Cette méthode permet de retourner les résultats de recherche pour la fonction d'autocomplete de l'ajout des bouteilles dans le cellier
	 * 
	 * @param string $nom La chaine de caractère à rechercher
	 * @param integer $nb_resultat Le nombre de résultat maximal à retourner.
	 * 
	 * @throws Exception Erreur de requête sur la base de données 
	 * 
	 * @return array id et nom de la bouteille trouvée dans le catalogue
	 */
       
	public function autocomplete($nom, $nb_resultat=10)
	{
		
		$lignes = Array();
		$nom = $this->_db->real_escape_string($nom);
		$nom = preg_replace("/\*/","%" , $nom);
		 
		//echo $nom;
		$requete ='SELECT id, nom FROM vino__bouteille where LOWER(nom) like LOWER("%'. $nom .'%") LIMIT 0,'. $nb_resultat; 
		//var_dump($requete);
		if(($res = $this->_db->query($requete)) ==	 true)
		{
			if($res->num_rows)
			{
				while($row = $res->fetch_assoc())
				{
					$row['nom'] = trim(utf8_encode($row['nom']));
					$lignes[] = $row;
					
				}
			}
		}
		else 
		{
			throw new Exception("Erreur de requête sur la base de données", 1);
			 
		}
		
		
		//var_dump($lignes);
		return $lignes;
	}
	
	
	/**
	 * Cette méthode ajoute une ou des bouteilles au cellier
	 * 
	 * @param Array $data Tableau des données représentants la bouteille.
	 * 
	 * @return Boolean Succès ou échec de l'ajout.
	 */
	public function ajouterBouteilleCellier($data)
	{
		//TODO : Valider les données.
		//var_dump($data);	
		
		$requete = "INSERT INTO vino__cellier(id_bouteille,date_achat,garde_jusqua,notes,prix,quantite,millesime) VALUES (".
		"'".$data->id_bouteille."',".
		"'".$data->date_achat."',".
		"'".$data->garde_jusqua."',".
		"'".$data->notes."',".
		"'".$data->prix."',".
		"'".$data->quantite."',".
		"'".$data->millesime."')";

        $res = $this->_db->query($requete);
        
		return $res;
	}
	
	
	/**
	 * Cette méthode change la quantité d'une bouteille en particulier dans le cellier
	 * 
	 * @param int $id id de la bouteille
	 * @param int $nombre Nombre de bouteille a ajouter ou retirer
	 * 
	 * @return Boolean Succès ou échec de l'ajout.
	 */
	public function modifierQuantiteBouteilleCellier($id, $nombre)
	{
		//TODO : Valider les données.
			
			
		$requete = "UPDATE vino_cellier__bouteille SET quantite = GREATEST(quantite + ". $nombre. ", 0) WHERE id = ". $id;
		//echo $requete;
        $res = $this->_db->query($requete);
        
		return $res;
	}

	/**
	 * Cette méthode récupére la quantité d'une bouteille en particulier dans le cellier
	 * 
	 * @param int $id id de la bouteille	
	 * 
	 * @return $row la ligne de la quntité de la bouteille en question.
	 */
	public function recupererQuantiteBouteilleCellier($id)
	{
			
		//Requete qui récupére la quantité d'une bouteille en particulier
		$requete1 = "SELECT quantite FROM vino_cellier__bouteille WHERE id = ". $id;
		$res1 = $this->_db->query($requete1);		
			
		$row = $res1->fetch_ASSOC(); 
		// retourner une ligne
        return $row;       
				
	}
}




?>