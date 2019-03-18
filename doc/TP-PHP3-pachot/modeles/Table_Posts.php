<?php
    class Table_Posts
    {
        public $id;
        public $idSujet;
        public $nomUsager;
        public $dateCreation;
        public $titre;
        public $texte;

        public function __construct($id = 0, $ids = 0, $nu = "", $dc = "", $t = "", $txt = "")
        {
            $this->id = $id;
            $this->idSujet = $ids;
            $this->nomUsager = $nu;
            $this->dateCreation = $dc;
            $this->titre = $t;
            $this->texte = $txt;
        }
    }
