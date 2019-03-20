<?php

	class DBFactory
	{
		public static function getDB($typeBD, $host, $dbName, $charset, $user, $pwd)
		{
			if($typeBD == 'mysql')
			{
				$laDB = new PDO('mysql:host=$host;dbname=$dbName;charset=$charset', $user, $pwd);
			}
			else if($typeBD == 'oracle')
			{
				$laDB = new PDO('oci:host=$host;dbname=$dbName;charset=$charset', $user, $pwd);		
			}
			else
			{
				trigger_error('Le type de BD spécifié n’est pas supporté.');
			}
			$laDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $laDB;
		}
	}
	
?>

