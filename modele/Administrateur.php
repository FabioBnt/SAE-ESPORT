<?php

include 'Database.php';

class Administrateur {
    public function __construct()
    {
    }
    public function creerEcurie(string $nom, string $compte, string $mdp, string $type)
    {
        Database::getInstance()->insert("Ecurie", "$nom, $compte, $mdp, $type");
    }
}