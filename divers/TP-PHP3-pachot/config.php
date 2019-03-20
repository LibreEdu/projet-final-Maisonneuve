<?php
    define("HOME", "/php/");

    // Chemin de l’installation sur le serveur
    define("RACINE", $_SERVER["DOCUMENT_ROOT"] . HOME);

    // Définition des constantes de connexion à la base de données
    define("DBTYPE", "mysql");
    define("DBNAME", "");
    define("HOST", "localhost");

    /* Local : Mac */
    define("USER", "root");
    define("PWD", "root"); /**/

    /* Local : Windows * /
    define("USER", "root");
    define("PWD", ""); /**/

    /* WebDev * /
    define("USER", "");
    define("PWD", ""); /**/

    define("PREFIXE", "php_");
    define("MAINADMIN", "admin");

    // Définition de ma fonction d’autoload
    function my_autoloader($classe)
    {
        $repertoires = array(RACINE . "controleurs/",
                             RACINE . "modeles/",
                             RACINE . "vues/"
                            );

        foreach($repertoires as $rep)
        {
            if(file_exists($rep . $classe . ".php"))
            {
                require_once($rep . $classe . ".php");
                return;
            }
        }
    }

    spl_autoload_register('my_autoloader');
