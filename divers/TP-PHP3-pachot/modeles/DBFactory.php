<?php

    class DBFactory
    {
        public static function getDB($typeBD, $dbName, $host, $user, $pwd)
        {
            if($typeBD == "mysql")
                $laDB = new PDO("mysql:host=$host;dbname=$dbName", $user, $pwd);
            else if($typeBD == "oracle")
                $laDB = new PDO("oci:host=$host;dbname=$dbName", $user, $pwd);
            else
                trigger_error("Le type de BD spécifié n'est pas supporté.");

            $laDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $laDB->exec("SET NAMES 'utf8'");
            return $laDB;
        }
    }
