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
            
            
        $requete = "UPDATE vino_bouteille SET quantite = GREATEST(quantite + ". $nombre. ", 0) WHERE id_bouteille = ". $id;
        //echo $requete;
        $res = $this->requete($requete);
        // var_dump($res);
        // die();
        
        return $res;
    }

    /**
     * Cette méthode récupére la quantité d'une bouteille en particulier dans le cellier
     * 
     * @param int $id id  cellier_bouteille 
     * 
     * @return $ligne la ligne de la quantité de la bouteille en question.
     */
    public function recupererQuantiteBouteilleCellier($id)
    {
            
        //Requete qui récupére la quantité d'une bouteille en particulier
        $requete = "SELECT quantite FROM vino_bouteille WHERE id_bouteille = ". $id;
        $resultat = $this->requete($requete);

        $resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Bouteille");
            $laBouteille = $resultat->fetch();
            return $laBouteille;    
            
        // $ligne = $res->fetch_ASSOC(); 
        // // retourner une ligne
        // return $ligne;
                
    }
        
    }

?>