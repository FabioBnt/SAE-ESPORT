<?php

include 'Connexion.php';

class Ecurie {
    private $connexion;
    public function __construct() {
        
    }

    public function connect($id,$mdp) {
        $this->connexion = Connexion::getInstance();
        $this->connexion->seConnecter($id,$mdp,Role::Ecurie);
    }
}