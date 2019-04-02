<?php
/**
 * Classe prise en compte lors de la récupération du jeu de résultat PDO.
 * 
 * @package  Vino
 * @version  1.0
 */
class Classe_Affichage
{
	public $id;
	public $id_liste_achat;
	public $id_bouteille_saq;

	public function __construct($id = 0, $id_liste_achat = 0, $nom = '')
	{
		$this->id = $id;
		$this->id_liste_achat = $id_liste_achat;
		$this->nom = $nom;
	}
}
