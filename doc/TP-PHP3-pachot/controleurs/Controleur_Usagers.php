<?php

    class Controleur_Usagers extends BaseControleur
    {
        public function traite(array $params)
        {
            // Affiche l’entête de la page
            $this->afficheVue("header");

            // Si le paramètre action existe
            if(isset($params["action"]))
            {
                switch($params["action"])
                {
                    case "authentification":
                        if(isset($params["nomUsager"], $params["motDePasse"]))
                        {
                            $modele = $this->getDAO();
                            $donnees["usager"] = $modele->obtenir_par_id($params["nomUsager"]);
                            if(password_verify($params["motDePasse"], $donnees["usager"]->motDePasse))
                            {
                                $_SESSION["nomUsager"]      = $donnees["usager"]->nomUsager;
                                $_SESSION["administrateur"] = $donnees["usager"]->administrateur;
                                $_SESSION["banni"]          = $donnees["usager"]->banni;
                                if ($_SESSION["banni"]) {
                                    $this->afficheVue("banni");
                                    $this->deconnexion();
                                }
                                else
                                    header("Location: index.php?Posts&action=sujets");
                            }
                            else
                                header("Location: index.php");
                        }
                        else
                            trigger_error("Un paramètre n’est pas défini.");
                        break;

                    case "deconnexion":
                        $this->deconnexion();
                        header("Location: index.php");
                        break;

                    case "usagers":
                        if (!($_SESSION["administrateur"]))
                            header("Location: index.php?Posts&action=sujets");
                        $this->accueil();
                        break;

                    case "bannir":
                        if(isset($params["nomUsager"]))
                            $this->bannir(1, $params["nomUsager"]);
                        else
                            trigger_error("Pas d’id spécifié...");
                        break;

                    case "gracier":
                        if(isset($params["nomUsager"]))
                            $this->bannir(0, $params["nomUsager"]);
                        else
                            trigger_error("Pas d’id spécifié...");
                        break;
                }
            }
            else
            {
                // Action par défaut : fenêtre d’authentification
                $this->afficheVue("authentification");
            }

            // Affiche le pied de page
            $this->afficheVue("footer");
        }

        private function deconnexion()
        {
            // Supprime le témoin de session en créant un nouveau témoin avec la date d’expiration dans le passé
            if(isset($_COOKIE[session_name()]))
                setcookie(session_name(), '', time() - 3600);

            // Détruit la session
            session_destroy();
        }

        // $banni = 1 pour bannir $nomUsager 
        // $banni = 0 pour gracier $nomUsager 
        private function bannir($banni, $nomUsager)
        {
            if ($_SESSION["administrateur"]) {
                $modele = $this->getDAO();
                $modele->mettre_a_jour($banni, "banni", $nomUsager);
                $this->accueil();
            } else
                header("Location: index.php?Posts&action=sujets");
        }

        private function accueil()
        {
                // Affiche le message de bienvenue et un lien pour de déconnecter
                $this->afficheVue("connexion");

                $modele = $this->getDAO();
                $donnees["usagers"] = $modele->obtenir_tous();
                $vue = "usagers";
                $this->afficheVue($vue, $donnees);
        }

    }
