<?php

include_once 'Connexion.php';


class Equipe
{
    private $id;
    private $nom;
    private $points;
    private $ecurie;
    private $jeu;
    public function __construct($id ,$nom, $points, $ecurie, $jeu){
        $this->id =$id;
        $this->nom = $nom;
        $this->points = $points;
        $this->ecurie = $ecurie;
        $this->jeu = $jeu;
    }

    public function inscrire(Tournoi $tournoi) {
        if(!$this->estConnecter()){
            throw new Exception('action qui nécessite une connexion en tant que membre du groupe');
        }
        // a verifier
        if(strtotime($tournoi->getDateLimiteInscription()) > strtotime(date("Y/m/d"))){
            throw new Exception('Inscription est fermée pour cette tournoi');
        }
        if($this->estParticipant($tournoi)){
            throw new Exception('Deja Inscrit');
        }
        $mysql = Database::getInstance();
        $mysql->Insert('Participer  (IdTournoi, IdEquipe)', 2, array($tournoi->getIdTournoi(), $this->id));

        return 1;
    }

    public function estParticipant(Tournoi $tournoi){
        $mysql = Database::getInstance();
        $data = $mysql->select('count(*) as total', 'Participer', 'where IdTournoi ='.$tournoi->getIdTournoi().' AND IdEquipe = '.$this->id);
        if ($data[0]['total'] > 0){
            return true;
        }
        return false;
    }
    // a modifier
    public static function getEquipe($id){
        return new Equipe(1, "test", 100, "test", "test");
    }
    public function toString() {
        return $this->nom;
    }
    public function estConnecter(){
        // pour le test
        return Connexion::getInstanceSansSession()->estConnecterEnTantQue(Role::Equipe);
    }


}
