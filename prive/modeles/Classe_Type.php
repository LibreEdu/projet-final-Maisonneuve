<?php
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
