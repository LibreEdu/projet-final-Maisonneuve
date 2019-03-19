<?php
    class Modele_Usagers extends BaseDAO
    {
        public function getClePrimaire()
        {
            return "nomUsager";
        }

        protected function lireTous()
        {
            $query = "SELECT * from {$this->getTableName()} ORDER BY nomUsager ASC";
            return $this->requete($query);
        }
    }
