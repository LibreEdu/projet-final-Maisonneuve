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
            $resultat = $this->lire($id);
            $resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Bouteille");
            $leRealisateur = $resultat->fetch();
            return $leRealisateur;
        }
        public function obtenir_tous()
        {
            $resultat = $this->lireTous();
            $lesRealisateurs = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Bouteille");
            return $lesRealisateurs;
        }
        
    }

?>