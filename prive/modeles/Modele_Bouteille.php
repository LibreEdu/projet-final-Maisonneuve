<?php
	class Modele_Bouteille extends BaseDAO
	{
		public function getTableName()
		{
			return 'vino_bouteille';
		}
		
		public function getClePrimaire()
		{
			return 'id_bouteille';
		}

		public function obtenir_par_id($id)
		{
			$resultat = $this->lire($id, 'id_bouteille');
			$maBouteille = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Bouteille');
			return $maBouteille;
		}

		public function obtenir_tous()
		{
			$resultat = $this->lireTous();
			$lesBouteilles = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Bouteille');
			return $lesBouteilles;
		}

		public function obtenir_par_id_cellier($id)
		{
			$resultat = $this->lire($id, 'id_cellier');
			$maBouteille = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Bouteille');
			return $maBouteille;
		}

		/**
		 * Cette méthode récupére les details des bouteilles en montrant le type a la place de id de type
		 * 
		 * @param int $id id cellier_bouteille 
		 * 
		 * @return $laBouteille details des bouteilles ainsi que le type de bouteille.
		 */
		public function lireAvecType($idCellier)
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
			$laBouteille = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Bouteille');			
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
		public function modifierQuantiteBouteilleCellier($id, $nombre)
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

			$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Bouteille');
			$laBouteille = $resultat->fetchALL();
			var_dump($laBouteille);
			return $laBouteille;    
		}
		
		/**
		 * Cette méthode permet de retourner les résultats de recherche pour la fonction d’autocomplete de l’ajout des bouteilles dans le cellier
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
			
			$listeBouteilles = Array();
			// $nom = real_escape_string($nom);
			// $nom = '*a*';
			$nom = preg_replace('/\*/','%' , $nom);
			// var_dump($nom);die;
			
			//echo $nom;
			$sql ='SELECT * FROM vino_bouteille_saq where LOWER(nom) like LOWER("%'.$nom.'%") LIMIT 0,'. $nb_resultat;
			// $sql ='SELECT * FROM vino_bouteille_saq';
			//$sql ='SELECT * FROM vino_bouteille_saq WHERE id_bouteille_saq=?';
			//$donnee = ['a'];



			// echo "ddd";die;

			$requete = $this->requete($sql);
			$bouteilles = $requete->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'BouteilleSaq');
			

			// var_dump($bouteilles);die;

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
			// var_dump($listeBouteilles);die;
			return $listeBouteilles;



			//$requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Bouteille');
				//$laBouteille = $resultat->fetch();
				//return $laBouteille; 
			//var_dump($resultat);die;

			// $lesNoms = $requete->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Bouteille');
			// var_dump($lesNoms);die;
			// return $lesCelliers;

			// if(($res = $this->requete($requete)) ==	 true)
			// {
			// 	if($res->num_rows)
			// 	{
			//		while($row = $requete->fetch_assoc())
			//		{
			//			$row['nom'] = trim(utf8_encode($row['nom']));
			//			$lignes[] = $row;
			//		}
			// 	}
			// }
			// else 
			// {
			// 	throw new Exception('Erreur de requête sur la base de données', 1);
				
			// }
			

			// while($lignes = $requete->fetch_assoc())
			// {
			// 	$
			// }
			//var_dump($resultat);
			// return $lignes;
		}

		public function modifierBouteille()
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

		public function ajouterUneBouteille()
		{
			$sql = 'INSERT INTO vino_bouteille (date_achat, quantite, prix, millesime, boire_avant, nom, pays, format, note, id_type, id_cellier) VALUES (?,?,?,?,?,?,?,?,?,?,?)';
			$donnees = array($_POST['date_achat'], $_POST['quantite'], $_POST['prix'], $_POST['millesime'], $_POST['boire_avant'], $_POST['nom'], $_POST['pays'], $_POST['format'], $_POST['note'], $_POST['type'], $_POST['id_cellier']);
			$resultat = $this->requete($sql, $donnees);
		}

		public function verifParUsager($idBouteille,$idUsager)
		{
			$sql = 'SELECT id_bouteille FROM ' . $this->getTableName() .'
			INNER JOIN vino_cellier cellier
				ON ' . $this->getTableName() .'.id_cellier = cellier.id_cellier
			WHERE id_bouteille = ? 
			AND id_usager = ?';

			$donnees = array($idBouteille,$idUsager);
			
			$resultat = $this->requete($sql,$donnees);
			// Récupère le résultat sous forme d’un objet
			$result = $resultat->fetch(PDO::FETCH_OBJ);
			return $result;
		}	
	}

?>