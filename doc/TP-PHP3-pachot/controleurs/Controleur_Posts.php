<?php

    class Controleur_Posts extends BaseControleur
    {
        public function traite(array $params)
        {
            // Affiche l’entête de la page
            $this->afficheVue("header");

            // Affiche le message de bienvenue et un lien pour de déconnecter
            $this->afficheVue("connexion");

            // Si le paramètre action existe
            if(isset($params["action"]))
            {
                switch($params["action"])
                {
                    // Affiche la liste des sujets
                    case "sujets":
                        $this->accueil();
                        break;

                    // Affiche en détail le sujet selectionné
                    case "sujet":
                        if(isset($params["id"]))
                        {
                            $modele = $this->getDAO();
                            $donnees["sujet"] = $modele->obtenir_par_id($params["id"]);
                            $donnees["reponses"] = $modele->obtenir_par_id($params["id"], "idSujet");
                            $this->afficheVue("sujet1", $donnees);
                            $this->afficheVue("sujet2", $donnees);
                            $this->afficheVue("sujet3");
                        }
                        else
                            trigger_error("Pas d’id spécifié...");
                        break;

                    // Supprime un sujet
                    case "supprimer":
                        if ($_SESSION["administrateur"]) {
                            if(isset($params["id"]))
                                {
                                    $modele = $this->getDAO();
                                    $modele->supprimer($params["id"], "idSujet");
                                    $modele->supprimer($params["id"]);
                                    $donnees["sujets"] = $modele->obtenir_tous();
                                    $vue = "sujets";
                                    $this->afficheVue($vue, $donnees);
                                }
                                else
                                    trigger_error("Pas d’id spécifié...");
                        } else
                            header("Location: index.php?Posts&action=sujets");
                        break;

                    // Affiche le formulaire d'ajout de réponse
                    case "formAjoutReponse":
                        $this->afficheFormAjoutReponse($params["id"]);
                        break;
                        
                    // Insere la nouvelle réponse dans la base de données
                    case "insereReponse":
                        $msgErreur = "";

                        // Validation des valeurs entrées dans le formulaire
                        if(isset($params["titre"], $params["reponse"])){
                            $message = $this->valideForm($params["titre"], $params["reponse"], "reponse");
                        }

                        // Récupère la date et l’heure au moment de l'ajout du commentaire
                        $dateCrea = $this->getDateCreation();

                        // S’il n’y a aucune erreur, on insère la nouvelle réponse dans la base de données
                        if($message == ""){
                            $modele = $this->getDAO("Posts");
                            $nouvelleReponse = new Table_Posts(0, $params["id"], $_SESSION["nomUsager"], $dateCrea, $params["titre"], $params["reponse"]);

                            $resultat = $modele->sauvegarde($nouvelleReponse);

                            $this->accueil();
                        }
                        // Sinon, on affiche un message d'erreur
                        else{
                            $message = "Réponse invalide.";
                            $this->afficheFormAjoutReponse($params["id"], $message);
                        }

                        break;

                    // Formulaire d’ajout de sujet
                    case "formAjoutSujet":
                            $vue = "formAjoutSujet";
                            $this->afficheVue($vue);
                        break;

                    // Insère un sujet dans la base de données
                    case "insereSujet":
                        $msgErreur = "";

                        // Validation des valeurs entrées dans le formulaire
                        if(isset($params["titre"], $params["question"])){
                            $message = $this->valideForm($params["titre"], $params["question"], "question");
                        }

                        // Récupère la date et l'heure au moment de l'ajout du commentaire
                        $dateCrea = $this->getDateCreation();

                        // S'il n'y a aucune erreur, on insère la nouvelle réponse dans la base de données
                        if($message == ""){
                            $modele = $this->getDAO("Posts");
                            $nouveauSujet = new Table_Posts(0,NULL, $_SESSION["nomUsager"], $dateCrea, $params["titre"], $params["question"]);

                            $resultat = $modele->sauvegarde($nouveauSujet);

                            $this->accueil();
                        }

                        // Sinon, on affiche un message d'erreur
                        else{
                            $donnees["erreurs"] = $message;
                            $vue = "formAjoutSujet";
                            $this->afficheVue($vue, $donnees);
                        }

                        break;
                }
            }
            else
                // Action par défaut : la liste de sujets
                header("Location: index.php?Sujets&action=sujets");

            // Affiche le pied de page
            $this->afficheVue("footer");
        }

        public function afficheFormAjoutReponse($id, $erreurs = "")
        {
            $modele = $this->getDAO();
            $donnees["erreurs"] =  $erreurs;
            $donnees["sujet"] = $modele->obtenir_par_id($id);
            $donnees["reponses"] = $modele->obtenir_par_id($id, "idSujet");
            $this->afficheVue("sujet1", $donnees);
            $this->afficheVue("formAjoutReponse", $donnees);
            $this->afficheVue("sujet3");
        }

        public function getDateCreation()
        {
            $today = getdate();
            $dateCrea = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"] . " " . $today["hours"] . ":" . $today["minutes"] . ":" . $today["seconds"];
            return $dateCrea;
        }

        // Validation du formulaire d'ajout de réponse
        public function valideForm($titre, $texte , $QouR)
        {
            $msgErreur = "";

            $titre = trim($titre);
            $texte = trim($texte);

            if($titre == "")
                $msgErreur .= "Votre $QouR doit avoir un titre avant de pouvoir l'envoyer.<br>";
            
            if(strlen($titre) > 250)
                $msgErreur .= "Le titre ne peut dépasser 250 caractères..<br>";
            
            if($texte == "")
                $msgErreur .= "Vous devez écrire une $QouR avant de pouvoir envoyer.<br>";
            
            return $msgErreur;
        }

        private function accueil()
        {
            $modele = $this->getDAO();
            $donnees["sujets"] = $modele->obtenir_tous();
            $vue = "sujets";
            $this->afficheVue($vue, $donnees);
        }
    }
