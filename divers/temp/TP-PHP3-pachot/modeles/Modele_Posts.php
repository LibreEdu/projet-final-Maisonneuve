<?php
    class Modele_Posts extends BaseDAO
    {
        public function sauvegarde(Table_Posts $commentaire)
        {
        	$query = "INSERT INTO " . $this->getTableName() . " (idSujet, nomUsager, dateCreation, titre, texte) VALUES (?, ?, ?, ?, ?)";
			$donnees = array($commentaire->idSujet, $commentaire->nomUsager, $commentaire->dateCreation, $commentaire->titre, $commentaire->texte);
			return $this->requete($query, $donnees);
        }
    }
