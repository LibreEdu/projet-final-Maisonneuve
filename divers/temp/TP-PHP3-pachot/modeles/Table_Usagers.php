<?php
    class Table_Usagers
    {
        public $nomUsager;
        public $motDePasse;
        public $administrateur;
        public $banni;

        public function __construct($nu = "", $mdp = "", $adm = 0, $ban = 0)
        {
            $this->nomUsager = $nu;
            $this->motDePasse = $mdp;
            $this->administrateur = $adm;
            $this->banni = $ban;
        }
    }
