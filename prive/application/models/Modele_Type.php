<?php
	class Modele_Type extends BaseDAO
	{
		public function getTableName()
		{
			return 'vino_type';
		}
		
		public function getClePrimaire()
		{
			return 'id_type';
		}
		public function obtenir_par_id($id)
		{
			$resultat = $this->lire($id, 'id_type');
			$maBouteille = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Type');
			return $maBouteille;
		}
		public function obtenir_tous()
		{
			$resultat = $this->lireTous();
			$lesTypes = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Bouteille');
			return $lesTypes;
		}
	}

?>