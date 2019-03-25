<?php

	class BaseDeDonnees
	{
		public static function obtenirBD($typeBD, $host, $dbName, $charset, $user, $pwd)
		{
			if($typeBD == 'mysql')
			{
				$connexion = new PDO("mysql:host=$host;dbname=$dbName;charset=$charset", $user, $pwd);
			}
			else if($typeBD == 'oracle')
			{
				$connexion = new PDO("oci:host=$host;dbname=$dbName;charset=$charset", $user, $pwd);		
			}
			else
			{
				trigger_error('Le type de BD spécifié n’est pas supporté.');
			}
			$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $connexion;
		}
	}
	
?>

