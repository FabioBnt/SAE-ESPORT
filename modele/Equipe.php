<?php
include_once 'Connexion.php';
include_once 'Ecurie.php';
include_once 'Database.php';
//créer une equipe
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
    //inscrire une equipe a une tournoi
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
    //récupéré l'id par le nom de l'équipe
    public static function getIDbyNom($nom) {
        $mysql = Database::getInstance();
        $data = $mysql->select("E.IdEquipe" , "Equipe E" , "where E.NomE ="."'$nom'");
        return $data[0]['IdEquipe'];
    }
    /**
     * @return mixed
     */
    //récupéré l'id de l'équipe
    public function getId(){
        return $this->id;
    }
    //récupéré le nom de l'équipe
    public function getNom(){
        return $this->nom;
    }
    /**
     * @return mixed
     */
    //récupéré l'id jeu de l'équipe
    public function getJeu()
    {
        return $this->jeu;
    }
    //récupéré la désignation de l'écurie de l'équipe
    public function getEcurie()
    {
        return Ecurie::getEcurie($this->ecurie)->getDesignation();
    }
    /**
     * @param Tournoi $tournoi
     * @return bool
     */
    //savoir si l'équipe est participant d'un tournoi X
    public function estParticipant(Tournoi $tournoi): bool
    {
        $mysql = Database::getInstance();
        $data = $mysql->select('count(*) as total', 'Participer', 'where IdTournoi ='.$tournoi->getIdTournoi().' AND IdEquipe = '.$this->id);
        if ($data[0]['total'] > 0){
            return true;
        }
        return false;
    }
    /**
     * @param $id
     * @return Equipe|null
     */
    //récupéré une équipe par son ID
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
     * @return mixed
     */
    //récupéré le nb de points
    public function getPoints()
    {
        if($this->points==""){
            return 0;
        } else {
            return $this->points;
        }
    }
    /**
     * @return array
     */
    //récupéré la liste des infos de l'équipe
    public function listeInfo() : array{
        return array($this->nom,Ecurie::getEcurie($this->ecurie)->getDesignation(),$this->jeu);
    }
    //récupéré la liste des infos pour le classement
    public function listeInfoClassement() : array {
        if($this->points==""){
            $this->points=0;
        }
        return array($this->nom,$this->points);
    }
    //récupéré les joueurs d'une équipe id
    public function getJoueurs($id)
    {
        $mysql = Database::getInstance();
        $dataE = $mysql->selectL('Pseudo,Nationalite', 'Joueur j', 'where IdEquipe ='.$id);
        return $dataE;
    }
    //récupéré le nb de match gagné de l'équipe
    public function getNbmatchG(){
        $listeTournois = new Tournois();
        $listeTournois->TournoisEquipe($this->id);
        $nb=0;
        foreach($listeTournois->getTournois() as $tournoi){
            $t=$tournoi->getPoules();
            $n = $this->jeu;
            if(array_key_exists($n,$t)){
                foreach($t[$n] as $poule){
                    if($poule->estPouleFinale()=='1'){
                        if($poule->meilleureEquipe()->getId()==$this->id){
                            $nb++;
                        }
                    }
                }
            }
        }
        return $nb;
    }
    //récupéré la somme des gains gagnés
    public function SommeTournoiG(){
        $listeTournois = new Tournois();
        $listeTournois->TournoisEquipe($this->id);
        $nb=0;
        foreach($listeTournois->getTournois() as $tournoi){
            $t=$tournoi->getPoules();
            $n = $this->jeu;
            if(array_key_exists($n,$t)){
                foreach($t[$n] as $poule){
                    if($poule->estPouleFinale()=='1'){
                        if($poule->meilleureEquipe()->getId()==$this->id){
                            $mysql = Database::getInstance();
                            $res = $mysql->selectL("T.CashPrize",
                            "Tournois T", "where T.IdTournoi=".$tournoi->getIdTournoi().'');
                            $nb=$nb+$res['CashPrize'];
                        }
                    }
                }
            }
        }
        return $nb;
    }
}
?>