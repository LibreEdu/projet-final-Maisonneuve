<?php
	class Controleur_aBouteille extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params['action'])
			{
				case 'index':
					break;

				default :
					trigger_error('Action invalide.');
			}
		}
	}
