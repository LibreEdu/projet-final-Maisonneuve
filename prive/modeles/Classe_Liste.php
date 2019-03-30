<?php
/**
 * Classe prise en compte lors de la récupération du jeu de résultat PDO.
 * 
 * @package  Vino
 * @version  1.0
 */
class Classe_Liste
{
	public $id_liste_achat;
	public $nom;

	public function __construct($id_liste_achat = 0, $nom = '')
	{
		$this->id_liste_achat = $id_liste_achat;
		$this->nom = $nom;
	}
}
