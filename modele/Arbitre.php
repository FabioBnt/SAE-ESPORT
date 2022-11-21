<?php

include 'Connexion.php';

class Arbitre {
    private $connexion;
    public function __construct($identifiant,$password) {
        $this->connexion = Connexion::getInstance();
        $this->connexion->seConnecter($identifiant,$password,Role::Arbitre);
    }
}