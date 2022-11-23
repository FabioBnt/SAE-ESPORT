<?php

include 'Connexion.php';

class Ecurie {
    private $designation;
    private $type;
    private $equipes = array();

    public function __construct($designation, $type, $equipes) {
        $this->designation = $designation;
        $this->type = $type;
        $this->equipes = $equipes;
    }
    public function creerEquipe($nom, $j1, $j2, $j3, $j4) {
    }

    public function getEquipes() {
        return $this->equipes;
    }

    public function getEquipe($nom) {
        return null;
    }

}