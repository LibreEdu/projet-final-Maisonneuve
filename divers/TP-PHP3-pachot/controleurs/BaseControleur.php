<?php
    abstract class BaseControleur
    {
        // La fonction qui sera appelée par le routeur
        public abstract function traite(array $params);

        // Retourne le nom du controleur, la partie après le "_" de la classe appelante
        protected function getName(){
            return substr(get_class($this), strpos(get_class($this), "_")+1);
        }

        protected function afficheVue($nomVue, $data = null)
        {
            $cheminVue = RACINE . "vues/" . $nomVue . ".php";

            if(file_exists($cheminVue))
                include_once($cheminVue);
            else
                trigger_error("Erreur 404! La vue $nomVue n’existe pas.");
        }

        // Retourne la classe (Modele_x) correspondante au nom du modèle ("x").
        // Elle contient une connexion à la base de données
        protected function getDAO($nomModele = "")
        {
            // Si le nom du modèle n'est pas fourni, on prend le nom du modèle correspondant à la classe appelante
            if($nomModele == "")
                $nomModele = $this->getName();

            $classe = "Modele_" . $nomModele;

            if(class_exists($classe))
            {
                // On fait une connexion à la BD
                $connexion = DBFactory::getDB(DBTYPE, DBNAME, HOST, USER, PWD);

                // On crée une instance de la classe Modele_$classe
                $objetModele = new $classe($connexion);

                if($objetModele instanceof BaseDAO)
                    return $objetModele;
                else
                    trigger_error("Modèle invalide.");
            }
        }
    }
