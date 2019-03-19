<?php
    class Modele_Cellier extends BaseDAO
    {       
        public function getTableName()
        {
            return "vino_cellier";
        }
        
        public function getClePrimaire()
        {
            return "id_cellier";
        }
        public function obtenir_par_id($id)
        {
            $resultat = $this->lire($id, 'id_type');
            $maBouteille = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Type");
            return $maBouteille;
        }
        public function obtenir_tous()
        {
            $resultat = $this->obtenirTous();
            $lesCelliers = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Bouteille");
            return $lesCelliers;
        }
        
    }

?>