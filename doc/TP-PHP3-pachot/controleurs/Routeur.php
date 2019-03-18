<?php
    class Routeur
    {
        public static function route()
        {
            // Récupére la chaine de caractères de l’URL ou des données du formulaire
            $chaineRequete = $_SERVER["QUERY_STRING"];

            // Cherche la position de la première occurrence de & dans la chaine de caractères
            $posEperluette = strpos($chaineRequete, "&");

            // Initialise le controleur
            $controleur = "";

            // Récupère le controleur
            if ($posEperluette === false)
                $controleur = $chaineRequete;
            else
                $controleur = substr($chaineRequete, 0, $posEperluette);

            // Si aucun contrôleur n’est spécifié, mettre le contrôleur par défaut
            if ($controleur == "")
                if (isset($_SESSION["nomUsager"]))
                    // Si l’usager est identifié, la page par défaut est celle de la liste des sujets
                    header("Location: index.php?Posts&action=sujets");
                else
                    // Sinon, on est redirigé vers la page d’authentification
                    $controleur = "Usagers";
            // Sinon
            // Si on ne vient pas du formulaire d’authentification
            elseif (isset($_REQUEST["action"]) && !($controleur == "Usagers" && $_REQUEST["action"] == "authentification"))
                // Si l’usager n’est pas authentifié
                if (!isset($_SESSION["nomUsager"]))
                    // On le redirige vers la page d’accueil
                    header("Location: index.php");

            // Déterminé la classe du controleur
            $classe = "Controleur_" . $controleur;

            // Si la classe existe
            if(class_exists($classe))
            {
                // Crée une nouvelle instance de la classe
                $objetControleur = new $classe;

                // Si l’objet est instancié d’une classe qui hérite de BaseControleur
                if($objetControleur instanceof BaseControleur)
                {
                    // Traite la requête
                    $objetControleur->traite($_REQUEST);
                }
                else
                    trigger_error("Controleur invalide.");
            }
            else
            {
                trigger_error("Erreur 404! Le controleur $controleur n’existe pas.");
            }
        }
    }
