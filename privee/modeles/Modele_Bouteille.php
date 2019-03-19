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
            $nom = mysqli_real_escape_string($nom);
            $nom = preg_replace("/\*/","%" , $nom);
            
            //echo $nom;
            $requete ='SELECT id_bouteille_saq, nom FROM vino_bouteille_saq where LOWER(nom) like LOWER("%'. $nom .'%") LIMIT 0,'. $nb_resultat; 
            if($res->num_rows)
            {
                while($row = $res->fetch_assoc())
                {
                    $row['nom'] = trim(utf8_encode($row['nom']));
                    $lignes[] = $row;
          
                }
            }
            
            
            //var_dump($lignes);
            return $lignes;
        }
    }

?>