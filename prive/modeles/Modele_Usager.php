<?php
	class Modele_Usager extends BaseDAO
	{
		public function getTableName()
		{
			return 'vino_usager';
		}
		
		public function getClePrimaire()
		{
			return 'id_usager';
		}
		public function obtenir_par_id($id)
		{
			$resultat = $this->lire($id);
			$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Usager');
			$Usager = $resultat->fetch();
			return $Usager;
		}
		public function obtenir_tous()
		{
			$resultat = $this->lireTous();
			$lesUsagers = $resultat->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Usager');
			return $lesUsagers;
		}

		/**
		 *  Fonction qui authentifie un utilisateur et qui retourne un 
		 *  booléen
		 *  @param string $username l’username de l’usager
		 *  @param string $password le mot de passe de l’usager
		 *  @return  boolean 
		 */
		public function  Authentification($username, $password)
		{
		
			$query = 'SELECT id_usager, hash from '. $this->getTableName() .' WHERE courriel = "' . $username . '"';
			$resultat = $this->requete($query);
			// Récuperer le résultat sous forme d'un objet
			$result = $resultat->fetch(PDO::FETCH_OBJ);

			if($result)
			{
				if(password_verify($password, $result->hash))
					return true;
				else
				{
					//ce n'est pas le bon mot de passe
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		/**
		 *  Fonction qui retourne le nom de l’usager username par son id
		 *  @param integer $id l’id de l’usager
		 *  @param string $colonne l’username de l’usager
		 *  @return  $lUsager
		 */
		 public function obtenirUsager($id, $colonne = 'courriel')
		{
			
			$resultat = $this->lire($id, $colonne);
			$resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Usager');
			$lUsager = $resultat->fetch();
			return $lUsager;
		}
		
		
	}

?>