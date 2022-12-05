<?php
include_once 'Connexion.php';
include_once 'Database.php';
include_once 'Role.php';

class Administrateur {
    public function __construct()
    {
    }
    public function creerEcurie(string $nom, string $compte, string $mdp, string $type)
    {
        
        Database::getInstance()->insert("Ecurie (Designation, TypeE, NomCompte, MDPCompte)", 4
         , array($nom, $type, $compte, $mdp));
    }

    public function creerTournoi(string $nom, int $cashPrize,string $notoriete, string $lieu,string $heureDebut,string $date){
        Database::getInstance()->insert("Tournois (NomTournoi, CashPrize, Notoriete, Lieu, DateHeureTournois)", 5
            , array($nom, $cashPrize, $notoriete, $lieu, $date.' '.$heureDebut.':00'));
    }
    public function estConnecter(){
        return Connexion::getInstanceSansSession()->estConnecterEnTantQue(Role::Administrateur);
    }
}