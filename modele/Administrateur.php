<?php
include_once 'Connexion.php';
include_once 'Database.php';
include_once 'Role.php';
include_once 'Jeu.php';
//Creer un administrateur
class Administrateur {
    //constructeur
    public function __construct()
    {
    }
    //creer une ecurie
    public function creerEcurie(string $nom, string $compte, string $mdp, string $type): void
    { 
        Database::getInstance()->insert("Ecurie (Designation, TypeE, NomCompte, MDPCompte)", 4
         , array($nom, $type, $compte, $mdp));
    }
    //creer un tournoi
    public function creerTournoi(string $nom, int $cashPrize,string $notoriete, string $lieu,string $heureDebut,string $date,array $jeux): void
    {
        if(!$this->estConnecter()){
            throw new RuntimeException('action qui nécessite une connexion en tant que membre du groupe');
        }
        Database::getInstance()->insert("Tournois (NomTournoi, CashPrize, Notoriete, Lieu, DateHeureTournois)", 5
            , array($nom, $cashPrize, $notoriete, $lieu, $date.' '.$heureDebut.':00'));
        $idTournoi = Database::getInstance()->select('T.IdTournoi','Tournois T','where T.NomTournoi = '."'$nom'");
        foreach ($jeux as $jeu) {
            Database::getInstance()->insert("Contenir",2,array($jeu,$idTournoi[0]['IdTournoi']));
        }
    }
    //verifier si administrateur est connecté
    public function estConnecter(): bool
    {
        return (Connexion::getInstanceSansSession()->estConnecterEnTantQue(Role::Administrateur)||Connexion::getInstance()->estConnecterEnTantQue(Role::Administrateur));
    }
}
