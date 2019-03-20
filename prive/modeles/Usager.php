<?php
	class Usager
	{
		public $id_usager;
		public $admin;
		public $actif;
		public $courriel;		
		public $nom;
		public $prenom;
		public $hash;
		
		
		public function __construct($id_usager = 0,  $admin = '',  $actif ='', $courriel = '', $nom = '', $prenom = '', $hash = '')
		{
			$this->id_usager = $id_usager;
			$this->admin = $admin;
			$this->actif = $actif;
			$this->courriel = $courriel;
			$this->nom = $nom;
			$this->prenom = $prenom;
			$this->hash = $hash;			
		}
	}
