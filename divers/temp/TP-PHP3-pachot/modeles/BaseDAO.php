<?php
    abstract class BaseDao
    {
        // Connexion à la base de données
        protected $db;

        // Initialise la connexionà la base de données
        public function __construct(PDO $dbPDO)
        {
            $this->db = $dbPDO;
        }

        public function obtenir_par_id($id, $colonne = NULL)
        {
            if(isset($colonne)) {
                $resultat = $this->lire($id, $colonne);
                $resultat = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->getClassName());
            }
            else {
                $resultat = $this->lire($id);
                $resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->getClassName());
                $resultat = $resultat->fetch();
            }
            return $resultat;
        }

        public function obtenir_tous()
        {
            $query = "SELECT * from " . $this->getTableName();
            $resultat = $this->requete($query);
            return $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->getClassName());
        }

        public function mettre_a_jour($valeur, $colonne, $valeurCondition, $colonneCondition = NULL)
        {
            if(isset($colonneCondition))
                $query = "UPDATE " . $this->getTableName() . " SET " . $colonne . "=? WHERE " . $colonneCondition . "=?";
            else
                $query = "UPDATE " . $this->getTableName() . " SET " . $colonne . "=? WHERE " . $this->getClePrimaire() . "=?";
            $donnees = array($valeur, $valeurCondition);
            return $this->requete($query, $donnees);
        }

        public function supprimer($cle, $colonne = NULL)
        {
            if(isset($colonne))
                $query = "DELETE FROM " . $this->getTableName() . " WHERE " . $colonne . "=?";
            else
                $query = "DELETE FROM " . $this->getTableName() . " WHERE " . $this->getClePrimaire() . "=?";
            $donnees = array($cle);
            return $this->requete($query, $donnees);
        }

        protected function lire($valeurCherchee, $colonne = NULL)
        {
            if(isset($colonne))
                $query = "SELECT * from " . $this->getTableName() . " WHERE " . $colonne . "=?";
            else
                $query = "SELECT * from " . $this->getTableName() . " WHERE " . $this->getClePrimaire() . "=?";
            $donnees = array($valeurCherchee);
            return $this->requete($query, $donnees);
        }

        final protected function requete($query, $data = array())
        {
            try
            {
                $stmt = $this->db->prepare($query);
                $stmt->execute($data);
            }
            catch(PDOException $e)
            {
                trigger_error("<p>La requête suivante a donné une erreur : $query</p><p>Exception : " . $e->getMessage() . "</p>");
                return false;
            }
            return $stmt;
        }

        // Retourne la valeur de la clé primaire
        protected function getClePrimaire(){
            return "id";
        }

        // Retourne le nom du modèle, la partie après le "_" de la classe appelante
        private function getName(){
            return substr(get_class($this), strpos(get_class($this), "_")+1);
        }

        // Retourne le nom de la classe modélisant l’objet correspondant à la table de la base de données
        private function getClassName(){
            return "Table_" . $this->getName();
        }

        // Retourne le nom de la table de la base de données correspondant au modèle
        protected function getTableName(){
            return PREFIXE . strtolower($this->getName());
        }

    }
