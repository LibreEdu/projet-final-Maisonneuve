<?php
class Modele_Type extends Modele
{
	public function getTableName()
	{
		return 'vino_type';
	}
	
	public function getClePrimaire()
	{
		return 'id_type';
	}
}