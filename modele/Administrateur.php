<?php

include 'Connexion.php';

class Administrateur {
    private $connexion;
    public function __construct($identifiant, $password)
    {
        $this->connexion = Connexion::getInstance();
        $this->identifiant = $identifiant;
        $this->connexion->seConnecter($identifiant, $password, Role::Administrateur);
    }
}