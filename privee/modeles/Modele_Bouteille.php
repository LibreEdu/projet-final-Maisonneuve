<?php
    class Modele_Bouteille extends BaseDAO
    {       
        public function getTableName()
        {
            return "vino_bouteille";
        }
        
        public function getClePrimaire()
        {
            return "id_bouteille";
        }
        public function obtenir_par_id($id)
        {
            $resultat = $this->lire($id, 'id_bouteille');
            $maBouteille = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Bouteille");
            return $maBouteille;
        }
        public function obtenir_tous()
        {
            $resultat = $this->lireTous();
            $lesRealisateurs = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Bouteille");
            return $lesRealisateurs;
        }
        
    }

?>