<?php
/**
 * Classe parente des modèles.
 *
 * @package  Vino
 * @author   Guillaume Harvey
 * @author   Alexandre Pachot
 * @version  1.0
 */
abstract class Modele
{
	/**
	 * @var object $object Connexion à la base de données
	 */
	protected $bd;


	/**
	 * Initialisation de la connexion à la base de données
	 * 
	 * @param object $bd_PDO Connexion à la base de données
	 * 
	 * @return void
	 */
	public function __construct(PDO $bd_PDO)
	{
		$this->bd = $bd_PDO;
	}

	/**
	 * Suppression d’un ou plusieurs enregistrements d’une table de la base de données.
	 * 
	 * @param string $valeurCherchee Clé primaire servant à filtrer les données qu’on veut supprimer.
	 *
	 * @param string $colonne Colonne sur laquelle on fait la recherche. Par défaut la recherche s’effectue sur la clé primaire.
	 *
	 * @return boolean Indique si la requête a correctement fonctionné.
	 */
	protected function supprimer($valeurCherchee,  $colonne = NULL)
	{
		if(!isset($colonne)){
			$sql = 'DELETE FROM ' . $this->getTableName() . ' WHERE ' . $this->getClePrimaire() .'=?';
		}
		else{
			$sql = 'DELETE FROM ' . $this->getTableName() . ' WHERE ' . $colonne .'=?';
		}
		$donnees = array($valeurCherchee);
		return $this->requete($sql, $donnees);
	}

	/**
	 * Récupère les enregistrements d’une table selon un critère précis.
	 * 
	 * @param string $valeurCherchee Condition de la clause WHERE
	 * @param string $colonne Colonne sur laquelle on fait la recherche. Par défaut la recherche s’effectue sur la clé primaire.
	 * 
	 * @return mixed Jeu de résultats si la requête a été correctement exécutée, false sinon.
	 */
	protected function lire($valeurCherchee, $colonne = NULL)
	{
		if(!isset($colonne)){
			$sql = 'SELECT * from ' . $this->getTableName() . ' WHERE ' . $this->getClePrimaire() .'=?';
		}
		else{
			$sql = 'SELECT * from ' . $this->getTableName() . ' WHERE ' . $colonne .'=?';
		}
		$donnees = array($valeurCherchee);
		return $this->requete($sql, $donnees);
	}


	/**
	 * Récupère tous les enregistrements d’une table.
	 * 
	 * @return mixed Jeu de résultats si la requête a été correctement exécutée, false sinon.
	 */
	protected function lireTous()
	{
		$sql = 'SELECT * from ' . $this->getTableName();
		return $this->requete($sql);
	}


	/**
	 * Exécute une requête sur la base de données.
	 * 
	 * @param string $sql Requête SQL
	 * 
	 * @return mixed Jeu de résultats si la requête a été correctement exécutée, false sinon.
	 * 
	 * @throws PDOException Si la préparation de la requête donne une erreur.
	 */
	final protected function requete($sql, $donnees = array())
	{
		try
		{
			$stmt = $this->bd->prepare($sql);
			$stmt->execute($donnees);
		}
		catch(PDOException $e)
		{
			trigger_error("<p>La requête suivante a donné une erreur : $sql</p><p>Exception : " . $e->getMessage() . '</p>');
			return false;
		}
		return $stmt;
	}


	/**
	 * Retourne le nombre d’enregistrements de la table.
	 * 
	 * @return integer Nombre d’enregistrements de la table.
	 */
	protected function total()
	{
		$sql = 'SELECT COUNT(*) as total from ' . $this->getTableName();
		return $this->requete($sql);
	}


	/**
	 * Retourne le nom de la clé primaire.
	 * 
	 * @return string Le nom de clé primaire.
	 */
	abstract function getClePrimaire();


	/**
	 * Retourne le nom de la table.
	 * 
	 * @return string Le nom de la table.
	 */
	abstract function getTableName();	
}
