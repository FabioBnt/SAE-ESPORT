<?php


class AdminDAO extends DAO{
    public function __construct(){
        parent::__construct();
    }

    // Insert an organization in the database (Ecurie table)
    public function createOrganization(string $nom, string $compte, string $mdp, string $type)
    { 
        // DAO::getInstance()->insert("Ecurie (Designation, TypeE, NomCompte, MDPCompte)", 4
        //  , array($nom, $type, $compte, $mdp));
        $connection = parent::getConnection();
        $sql = "INSERT INTO Ecurie (Designation, TypeE, NomCompte, MDPCompte) VALUES (:nom, :type, :compte, :mdp)";
        $stmt = $connection->prepare($sql);
        $stmt->execute(array(
            ':nom' => $nom,
            ':type' => $type,
            ':compte' => $compte,
            ':mdp' => $mdp
        ));

    }

    // //creer un tournoi
    // public function creerTournoi(string $nom, int $cashPrize,string $notoriete, string $lieu,string $heureDebut,string $date,array $jeux): void
    // {
    //     if(!$this->estConnecter()){
    //         throw new RuntimeException('action qui nécessite une connexion en tant que membre du groupe');
    //     }
    //     DAO::getInstance()->insert("Tournois (NomTournoi, CashPrize, Notoriete, Lieu, DateHeureTournois)", 5
    //         , array($nom, $cashPrize, $notoriete, $lieu, $date.' '.$heureDebut.':00'));
    //     $idTournoi = DAO::getInstance()->select('T.IdTournoi','Tournois T','where T.NomTournoi = '."'$nom'");
    //     foreach ($jeux as $jeu) {
    //         DAO::getInstance()->insert("Contenir",2,array($jeu,$idTournoi[0]['IdTournoi']));
    //     }
    // }
    // //verifier si administrateur est connecté
    // public function estConnecter(): bool
    // {
    //     return (Connexion::getInstanceSansSession()->estConnecterEnTantQue(Role::Administrateur)||Connexion::getInstance()->estConnecterEnTantQue(Role::Administrateur));
    // }
}