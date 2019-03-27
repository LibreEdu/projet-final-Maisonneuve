<?php
/**
 * Classe cellier prise en compte lors de la récupération du jeu de résultat PDO
 *
 * @package  Vino 
 * @author   Fatemeh Homatash
 * @version  1.0
 */
class Classe_Cellier
{
	public $id_cellier;
	public $id_usager;
	public $nom;
	
	public function __construct($id_cellier = 0, $id_usager = 0, $nom = '')
	{
		$this->id_cellier = $id_cellier;
		$this->id_usager = $id_usager;
		$this->nom = $nom;
	}
}
