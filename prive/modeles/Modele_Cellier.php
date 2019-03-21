<?php
	class Modele_Cellier extends BaseDAO
	{       
		public function getTableName()
		{
			return 'vino_cellier';
		}
		
		public function getClePrimaire()
		{
			return 'id_cellier';
		}

		public function obtenir_par_id($id)
		{
			$resultat = $this->lire($id, 'id_usager');
			$monCellier = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Cellier');
			return $monCellier;
		}

		public function obtenir_tous()
		{
			$resultat = $this->obtenirTous();
			$lesCelliers = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Cellier');
			return $lesCelliers;
		}
		
		public function supprimer_par_id($id)
		{
			$resultat = $this->supprimer($id);
			return $resultat;
		}

		public function ajoutCellier($idUsager)
		{
			$sql = 'INSERT INTO ' . $this->getTableName() . '(id_usager, nom) VALUES (?,?)';
			$donnees = array($idUsager, $_POST['nom']);
			$resultat = $this->requete($sql, $donnees);
		}	
	}
?>