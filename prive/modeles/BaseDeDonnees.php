<?php

	class BaseDeDonnees
	{
		public static function obtenirBD($typeBD, $host, $dbName, $charset, $user, $pwd)
		{
			if($typeBD == 'mysql')
			{
				$BD = new PDO("mysql:host=$host;dbname=$dbName;charset=$charset", $user, $pwd);
			}
			else if($typeBD == 'oracle')
			{
				$BD = new PDO("oci:host=$host;dbname=$dbName;charset=$charset", $user, $pwd);		
			}
			else
			{
				trigger_error('Le type de BD spécifié n’est pas supporté.');
			}
			$BD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $BD;
		}
	}
	
?>

