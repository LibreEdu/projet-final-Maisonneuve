<?php
    class Routeur
    {
        public static function route()
        {
            //obtenir la chaine de la requête
            $chaineRequete = $_SERVER["QUERY_STRING"];
            $posEperluette = strpos($chaineRequete, "&");
            $controleur = "";
            if($posEperluette === false)
                $controleur = $chaineRequete;
            else
                $controleur = substr($chaineRequete, 0, $posEperluette);
            
            //si aucun contrôleur n'a été spécifié, mettre un contrôleur par défaut
            if($controleur == "")
                $controleur = "Bouteille";
            
            //on a déterminé le controleur
            //on en crée une instance si la classe existe
            $classe = "Controleur_" . $controleur;            
          
            if(class_exists($classe))
            {
                //déclaration du controleur et traitement de la requête...
                $objetControleur = new $classe;
                
                if($objetControleur instanceof BaseControleur)
                {
                    $objetControleur->traite($_REQUEST);
                }
                else
                    trigger_error("Controleur invalide.");
            }
            else
            {
                trigger_error("Erreur 404! Le controleur $controleur n'existe pas.");
            }
        }
    }
?>