<?php

include_once 'Connexion.php';
include_once 'Ecurie.php';


class Equipe
{
    private $id;
    private $nom;
    private $points;
    private $ecurie;
    private $jeu;

    /**
     * @param $id
     * @param $nom
     * @param $points
     * @param $ecurie
     * @param $jeu
     */
    public function __construct($id , $nom, $points, $ecurie, $jeu){
        $this->id =$id;
        $this->nom = $nom;
        $this->points = $points;
        $this->ecurie = $ecurie;
        $this->jeu = $jeu;
    }

    /**
     * @param Tournoi $tournoi
     * @return int
     * @throws Exception
     */
    public function inscrire(Tournoi $tournoi): int
    {
        if(!$this->estConnecter()){
            throw new Exception('action qui nécessite une connexion en tant que membre du groupe');
        }
        $nbParti = $tournoi->numeroParticipants($this->jeu->getId());
        if($nbParti ===16){
            throw new Exception('tournoi complet');
        }
        if(!$tournoi->contientJeu($this->jeu)){
            throw new Exception('L\'equipe n\'est pas expert dans les jeux de tournoi');
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
        $nbParti++;
        if($nbParti === 16){
            $tournoi->genererLesPoules($this->jeu->getID());
        }

        return 1;
    }

    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getJeu()
    {
        return $this->jeu;
    }


    /**
     * @param Tournoi $tournoi
     * @return bool
     */
    public function estParticipant(Tournoi $tournoi): bool
    {
        $mysql = Database::getInstance();
        $data = $mysql->select('count(*) as total', 'Participer', 'where IdTournoi ='.$tournoi->getIdTournoi().' AND IdEquipe = '.$this->id);
        if ($data[0]['total'] > 0){
            return true;
        }
        return false;
    }
    // a modifier

    /**
     * @param $id
     * @return Equipe|null
     */
    public static function getEquipe($id): ?Equipe
    {
        $equipe = null;
        $mysql = Database::getInstance();
        $dataE = $mysql->select('*', 'Equipe e, Jeu j', 'where IdEquipe ='.$id.' AND j.IdJeu = e.IdJeu');
            foreach($dataE as $ligneE){
                $equipe = new Equipe($ligneE['IdEquipe'], $ligneE['NomE'], $ligneE['NbPointsE'], $ligneE['IDEcurie'], 
                new Jeu($ligneE['IdJeu'],$ligneE['NomJeu'], $ligneE['TypeJeu'], $ligneE['TempsDeJeu'], $ligneE['DateLimiteInscription']));
            }
        return $equipe;
    }
    public function __toString() {
        return $this->nom;
    }

    /**
     * @return bool
     */
    public function estConnecter(): bool
    {
        // pour le test
        return (Connexion::getInstanceSansSession()->estConnecterEnTantQue(Role::Equipe) || Connexion::getInstance()->estConnecterEnTantQue(Role::Equipe));
    }

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return array
     */
    public function listeInfo() : array{
        return array($this->nom,$this->points,Ecurie::getEcurie($this->ecurie)->getDesignation(),$this->jeu);
    }

}
