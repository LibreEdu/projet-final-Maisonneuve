<?php
	class Controleur_Admin extends BaseControleur
	{
		public function traite(array $params)
		{
			if ( ! ( isset($_SESSION["admin"]) && $_SESSION["admin"] == true) )
			{
				header('Location: ' . BASEURL );
			}
			switch($params['action'])
			{
				case 'index':
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modeles/menu-admin');
					$this->afficheVue('admin/principal');
					$this->afficheVue('modeles/bas-de-page');
					break;

				default :
					trigger_error('Action invalide.');
			}
		}
	}
