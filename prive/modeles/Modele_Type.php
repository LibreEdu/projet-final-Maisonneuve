<?php
	class Modele_Type extends Modele
	{
		public function getTableName()
		{
			return 'vino_type';
		}
		
		public function getClePrimaire()
		{
			return 'id_type';
		}

		public function obtenir_tous()
		{
			$resultat = $this->lireTous();
			$lesTypes = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Bouteille');
			return $lesTypes;
		}
	}

?>