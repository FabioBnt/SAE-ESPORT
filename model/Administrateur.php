<?php
include_once 'Connexion.php';
include_once 'DAO.php';
include_once 'Role.php';
include_once 'Jeu.php';
//Creer un administrateur
class Administrateur {
    //constructeur
    public function __construct()
    {
    }
    
    //verifier si administrateur est connecté
    public function isConnected(): bool
    {
        return (Connexion::getInstanceSansSession()->estConnecterEnTantQue(Role::Administrateur)||Connexion::getInstance()->estConnecterEnTantQue(Role::Administrateur));
    }
}
