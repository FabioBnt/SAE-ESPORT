<?php
include_once 'Connexion.php';
include_once 'Ecurie.php';
include_once 'DAO.php';
//créer une equipe
class Equipe
{
    private int $id;
    private string $nom;
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
    //constructeur
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
    //inscrire une équipe a un tournoi
    public function inscrire(Tournoi $tournoi): int
    {
        if(!$this->estConnecter()){
            throw new \RuntimeException('action qui nécessite une connexion en tant que membre du groupe');
        }
        $nbParti = $tournoi->numeroParticipants($this->jeu->getId());
        if($nbParti ===16){
            throw new \RuntimeException('tournoi complet');
        }
        if(!$tournoi->contientJeu($this->jeu)){
            throw new \RuntimeException('L\'équipe n\'est pas expert dans les jeux du tournoi');
        }
        if(strtotime($tournoi->getDateLimiteInscription()) > strtotime(date("Y/m/d"))){
            throw new \RuntimeException('L\'inscription est fermée pour ce tournoi');
        }
        if($this->estParticipant($tournoi)){
            throw new \RuntimeException('Déjà inscrit');
        }
        $mysql = DAO::getInstance();
        $mysql->Insert('Participer  (IdTournoi, IdEquipe)', 2, array($tournoi->getIdTournoi(), $this->id));
        $nbParti++;
        if($nbParti === 16){
            $tournoi->genererLesPoules($this->jeu->getID());
        }
        return 1;
    }
    //récupérer l'id par le nom de l'équipe
    public static function getIDbyNom($nom) : int {
        $mysql = DAO::getInstance();
        $data = $mysql->select("E.IdEquipe" , "Equipe E" , "where E.NomE ="."'$nom'");
        return $data[0]['IdEquipe'];
    }
    /**
     * @return int
     */
    //récupérer l'id de l'équipe
    public function getId() : int{
        return $this->id;
    }
    //récupérer le nom de l'équipe

    /**
     * @return string
     */
    public function getNom() : string{
        return $this->nom;
    }
    
    //récupérer le jeu de l'équipe en type Jeu
    /**
     * @return Jeu
     */
    public function getJeu() : Jeu
    {
        return $this->jeu;
    }
     //récupérer le jeu de l'équipe en type string
    /**
     * @return string
     */
    public function getJeuN() : string
    {
        $mysql = DAO::getInstance();
        $data = $mysql->selectL("J.NomJeu",
        "Jeu J", "where J.IdJeu =".$this->getJeuS().'');
        return $data['NomJeu'];

    }
    //récupérer l'id jeu de l'équipe
    public function getJeuS() : string
    {
        return $this->jeu;
    }
    
    //récupérer la désignation de l'écurie de l'équipe
    public function getEcurie() : string{
        return Ecurie::getEcurie($this->ecurie)->getDesignation();
    }
    /**
     * @param Tournoi $tournoi
     * @return bool
     */
    //savoir si l'équipe est participant d'un tournoi X
    public function estParticipant(Tournoi $tournoi): bool
    {
        $mysql = DAO::getInstance();
        $data = $mysql->select('count(*) as total', 'Participer', 'where IdTournoi ='.$tournoi->getIdTournoi().' AND IdEquipe = '.$this->id);
        return $data[0]['total'] > 0;
    }
    /**
     * @param $id
     * @return Equipe
     */
    //récupérer une équipe par son ID
    public static function getEquipe($id): Equipe
    {
        $equipe = null;
        $mysql = DAO::getInstance();
        $dataE = $mysql->select('*', 'Equipe e, Jeu j', 'where IdEquipe ='.$id.' AND j.IdJeu = e.IdJeu');
            foreach($dataE as $ligneE){
                $equipe = new Equipe($ligneE['IdEquipe'], $ligneE['NomE'], $ligneE['NbPointsE'], $ligneE['IDEcurie'], 
                new Jeu($ligneE['IdJeu'],$ligneE['NomJeu'], $ligneE['TypeJeu'], $ligneE['TempsDeJeu'], $ligneE['DateLimiteInscription']));
            }
        return $equipe;
    }
    //to string
    public function __toString() {
        return ''.$this->nom;
    }
    /**
     * @return bool
     */
    //savoir si l'équipe est connectée
    public function estConnecter(): bool
    {
        return (Connexion::getInstanceSansSession()->estConnecterEnTantQue(Role::Equipe) || Connexion::getInstance()->estConnecterEnTantQue(Role::Equipe));
    }
    /**
     * @return int
     */
    //récupérer le nb de points
    public function getPoints(): int
    {
        if($this->points==""){
            return 0;
        }
        return $this->points;
    }
    /**
     * @return array
     */
    //récupérer la liste des infos de l'équipe
    public function listeInfo() : array{
        return array($this->nom,Ecurie::getEcurie($this->ecurie)->getDesignation(),$this->jeu);
    }
    //récupérer la liste des infos pour le classement
    public function listeInfoClassement() : array {
        if($this->points==""){
            $this->points=0;
        }
        return array($this->nom,$this->points);
    }
    //récupérer les joueurs d'une équipe id
    public function getJoueurs($id)
    {
        $mysql = DAO::getInstance();
        $dataE = $mysql->select('Pseudo,Nationalite', 'Joueur j', 'where IdEquipe ='.$id);
        return $dataE;
    }
    //récupérer le nb de match gagné de l'équipe
    public function getNbmatchG(): int
    {
        $listeTournois = new Tournois();
        $listeTournois->TournoisEquipe($this->id);
        $nb=0;
        foreach($listeTournois->getTournois() as $tournoi){
            $t=$tournoi->getPoules();
            $n = null;
            if ($this->jeu instanceof Jeu) {
                $n = $this->jeu->getId();
            }else{
                $n = $this->jeu - '0';
            }
            if(array_key_exists($n,$t)){
                foreach($t[$n] as $poule){
                    if($poule->estPouleFinale()==='1'){
                        if($poule->meilleureEquipe()->getId()===$this->id){
                            $nb++;
                        }
                    }
                }
            }
        }
        return $nb;
    }
    //récupérer la somme des gains gagnés
    public function SommeTournoiG(){
        $listeTournois = new Tournois();
        $listeTournois->TournoisEquipe($this->id);
        $nb=0;
        foreach($listeTournois->getTournois() as $tournoi){
            $t=$tournoi->getPoules();
            $n = null; 
            if ($this->jeu instanceof Jeu) {
                $n = $this->jeu->getId();
            }else{
                $n = $this->jeu - '0';
            }
            if(array_key_exists($n,$t)){
                foreach($t[$n] as $poule){
                    if($poule->estPouleFinale()==='1'){
                        if($poule->meilleureEquipe()->getId()===$this->id){
                            $mysql = DAO::getInstance();
                            $res = $mysql->selectL("T.CashPrize",
                            "Tournois T", "where T.IdTournoi=".$tournoi->getIdTournoi().'');
                            $nb += $res['CashPrize'];
                        }
                    }
                }
            }
        }
        return $nb;
    }
}