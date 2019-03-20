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


		 public function sauvegarde(Usager $lUsager)
        {

		$query = "INSERT INTO " . $this->getTableName() . " (courriel, admin, actif, nom, prenom, hash) VALUES (?, ?, ?, ?, ?, ?)";
				$donnees = array($lUsager->courriel, $lUsager->admin, $lUsager->actif, $lUsager->nom, $lUsager->prenom, $lUsager->hash);
				return $this->requete($query, $donnees);

		}

		 public function verif(){
        
         if(empty($_POST['pseudo']))
					    {
					    	$message = 'Le champ Courriel est vide';
								
							$donnees['erreurs'] = $message;
					        //echo "Le champ Pseudo est vide.";
					    } 
					    elseif(!preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#",$_POST['pseudo']))
					    {
					    	$message = 'le format devra réspecter celui du courriel.';
								
							$donnees['erreurs'] = $message;
					        //echo "Le Pseudo doit être renseigné en lettres minuscules sans accents, sans caractères spéciaux.";
					    }

					    elseif(!preg_match("#^[a-z0-9]+$#",$_POST['nom']))
					    {
					    	$message = 'Le Nom ne doit pas contenir de chiffres';
								
							$donnees['erreurs'] = $message;
					        //echo "Le Pseudo doit être renseigné sans chiffres ni caractères spéciaux.";
					    }

					    elseif(!preg_match("#^[a-z0-9]+$#",$_POST['prenom']))
					    {
					    	$message = 'Le Prénom ne doit pas contenir de chiffres';
								
							$donnees['erreurs'] = $message;
					        //echo "Le Prénom doit être renseigné sans chiffres ni caractères spéciaux.";
					    }   
					  //   elseif(strlen($_POST['pseudo'])>25)
					  //   {
					  //   	$message = 'Le pseudo est trop long, il dépasse 25 caractères.';
								
							// $donnees['erreurs'] = $message;
					  //      // echo "Le pseudo est trop long, il dépasse 25 caractères.";
					  //   } 
					    elseif(empty($_POST['mdp']))
					    {//le champ mot de passe est vide
					    	$message = 'Le champ Mot de passe est vide.';
								
							$donnees['erreurs'] = $message;
					        //echo "Le champ Mot de passe est vide.";
					    }
					    elseif(strlen($_POST['mdp'])>12|| strlen($_POST['mdp'])<5)
					    {
					    	$message = 'Le mot de passe doit contenir entre 6 à 12 caracteres maximum.';
								
							$donnees['erreurs'] = $message;
					        //echo "Le mot de passe doit contenir entre 6 à 12 caracteres maximum.";
					    }
					    elseif (($_POST['mdp']) != ($_POST['mdp2']) ) 
					    {
					      	$message = 'Les mots de passe doivent être identique.';
								
							$donnees['erreurs'] = $message;
					    }  
					    elseif(($modeleUsager->obtenirUsager($_REQUEST['pseudo'])))
					    {//on vérifie que ce pseudo n'est pas déjà utilisé par un autre membre
							$message = 'Ce pseudo est déjà utilisé.';
								
							$donnees['erreurs'] = $message;
					        //echo "Ce pseudo est déjà utilisé.";
					    } 
        
    }
		
		
	}

?>