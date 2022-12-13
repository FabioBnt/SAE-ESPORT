<?php
include_once 'Connexion.php';
include_once 'Database.php';
include_once 'Role.php';
include_once 'Jeu.php';

class Administrateur {
    public function __construct()
    {
    }
    public function creerEcurie(string $nom, string $compte, string $mdp, string $type)
    {
        
        Database::getInstance()->insert("Ecurie (Designation, TypeE, NomCompte, MDPCompte)", 4
         , array($nom, $type, $compte, $mdp));
    }

    public function creerTournoi(string $nom, int $cashPrize,string $notoriete, string $lieu,string $heureDebut,string $date,array $jeux){
        if(!$this->estConnecter()){
            throw new Exception('action qui nécessite une connexion en tant que membre du groupe');
        }
        Database::getInstance()->insert("Tournois (NomTournoi, CashPrize, Notoriete, Lieu, DateHeureTournois)", 5
            , array($nom, $cashPrize, $notoriete, $lieu, $date.' '.$heureDebut.':00'));
        $idTournoi = Database::getInstance()->select('T.IdTournoi','Tournois T','where T.NomTournoi = '."'$nom'");
        foreach ($jeux as $jeu) {
            Database::getInstance()->insert("Contenir",2,array($jeu,$idTournoi[0]['IdTournoi']));
        }
    }
    public function estConnecter(){
        return Connexion::getInstanceSansSession()->estConnecterEnTantQue(Role::Administrateur);
    }
}