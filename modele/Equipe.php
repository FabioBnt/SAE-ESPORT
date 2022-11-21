<?php

include 'Connexion.php';


class Equipe
{
    private $connexion;

    public function __construct(){
    }

    public function connecter($id,$mdp){
        $this->connexion = Connexion::getInstance();
        $this->connexion->seConnecter($id,$mdp,Role::Equipe);
    }
}
