<?php
/**
 * Classe prise en compte lors de la récupération du jeu de résultat PDO.
 * 
 * @package  Vino
 * @version  1.0
 */
class Classe_Type
{
	public $id_type;
	public $type;

	public function __construct($id_type = 0, $type = '')
	{
		$this->id_type = $id_type;
		$this->type = $type;
	}
}
