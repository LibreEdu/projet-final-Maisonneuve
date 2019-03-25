<?php
/**
 * Classe Type
 * @package  Vino  
 * @author   José Ignacio Delgado
 *.@author...Fatemeh Homatash
 * @author   Alexandre Pachot
 *.@author...Charef Eddine Yagoubi
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
