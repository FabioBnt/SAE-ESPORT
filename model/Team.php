<?php
include_once 'Connexion.php';
include_once 'Ecurie.php';
include_once '../dao/TeamDAO.php';
//create a team
class Team
{
    private int $id;
    private string $name;
    private int $points;
    private string $ecurie;
    private $game;
    private $teams;
    /**
     * @param $id
     * @param $name
     * @param $points
     * @param $ecurie
     * @param $game
     */
    //constructor
    public function __construct($id , $name, $points, $ecurie, $game){
        $this->id =$id;
        $this->name = $name;
        $this->points = $points;
        $this->ecurie = $ecurie;
        $this->game = $game;
        $this->teams = array();
    }
    /**
     * @return bool
     */
    //savoir si l'équipe est connectée
    public function isConnected(): bool
    {
        return (Connexion::getInstanceWithoutSession()->estConnecterEnTantQue(Role::Team) || Connexion::getInstance()->estConnecterEnTantQue(Role::Team));
    }
    /**
     * @param Tournoi $tournoi
     * @return int
     */
    //get id of a team by his name
    public static function getIDbyname($name) : int {
        $dao= new TeamDAO();
        return $dao->selectIDbyNameTeam($name);
    }
    /**
     * @return int
     */
    //get id of the team
    public function getId() : int{
        return $this->id;
    }
    /**
     * @return string
     */
    //get name of the team
    public function getname() : string{
        return $this->name;
    }
    /**
     * @return int
     */
    //get poins of the team
    public function getPoints(): int
    {
        if($this->points==""){
            return 0;
        }
        return $this->points;
    }
    /**
     * @return string
     */
    //get game name of the team by his id
    public function getGameName() : string
    {
        $dao= new TeamDAO();
        return $dao->selectGameName($this->id);
    }
    //get id game of the team
    public function getgameId() : string
    {
        return $this->game;
    }
    //get organization name of the team
    public function getEcurie() : string{
        return Ecurie::getOrganization($this->ecurie)->getDesignation();
    }
    /**
     * @param Tournoi $tournoi
     * @return bool
     */
    //know if team participate of the x tournament
    public function getIfTeamOnTournament(Tournoi $tournoi): bool
    {
        $dao= new TeamDAO();
        return $dao->TeamOnTournament($tournoi,$this->id);
    }
    /**
     * @param $id
     * @return Team
     */
    //get team by his id
    public static function getTeam($id): Team
    {
        $dao= new TeamDAO();
        return $dao->selectTeamByID($id);
    }
    //get players of a id team
    public function getPlayers($id)
    {
        $dao= new TeamDAO();
        return $dao->selectPlayers($id);
    }
    //get nb match win by the team
    public function getNbmatchWin(): int
    {
        $listeTournois = new Tournois();
        $listeTournois->tournamentsParticipatedByTeam($this->id);
        $nb=0;
        foreach($listeTournois->getTournois() as $tournoi){
            $t=$tournoi->getPoules();
            $n = null;
            if ($this->game instanceof game) {
                $n = $this->game->getId();
            }else{
                $n = $this->game - '0';
            }
            if(array_key_exists($n,$t)){
                foreach($t[$n] as $poule){
                    if($poule->estPouleFinale()==='1'){
                        if($poule->meilleureTeam()->getId()===$this->id){
                            $nb++;
                        }
                    }
                }
            }
        }
        return $nb;
    }
    //cashprize win by the team
    public function sommeTournamentWin(){
        $listeTournois = new Tournois();
        $listeTournois->tournamentsParticipatedByTeam($this->id);
        $nb=0;
        foreach($listeTournois->getTournois() as $tournoi){
            $t=$tournoi->getPoules();
            $n = null; 
            if ($this->game instanceof game) {
                $n = $this->game->getId();
            }else{
                $n = $this->game - '0';
            }
            if(array_key_exists($n,$t)){
                foreach($t[$n] as $poule){
                    if($poule->estPouleFinale()==='1'){
                        if($poule->meilleureTeam()->getId()===$this->id){
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
    //register a team to a tournament
    public function register(Tournoi $tournoi): int
    {
        if(!$this->isConnected()){
            throw new \RuntimeException('action qui nécessite une connexion en tant que membre du groupe');
        }
        $nbParti = $tournoi->numeroParticipants($this->game->getId());
        if($nbParti ===16){
            throw new \RuntimeException('tournoi complet');
        }
        if(!$tournoi->contientJeu($this->game)){
            throw new \RuntimeException('L\'équipe n\'est pas expert dans les gamex du tournoi');
        }
        if(strtotime($tournoi->getDateLimiteInscription()) > strtotime(date("Y/m/d"))){
            throw new \RuntimeException('L\'inscription est fermée pour ce tournoi');
        }
        if($this->getIfTeamOnTournament($tournoi)){
            throw new \RuntimeException('Déjà inscrit');
        }
        $dao= new TeamDAO();
        $dao->insertTeamTournament($tournoi->getIdTournoi(), $this->id);
        $nbParti++;
        if($nbParti === 16){
            $tournoi->genererLesPoules($this->game->getID());
        }
        return 1;
    }
    // TEAMS //
    // get team list
    public function getTeamList($id){
        $dao= new TeamDAO();
        $data = $dao->selectTeam($id);
        $this->updateTeamList($data);
        return $this->teams;
    }
    //mettre a jour la liste
    private function updateTeamList($data){
        $this->teams = array();
        $last = -1;
        $index = -1;
        foreach ($data as $ligne) {
            if($last != $ligne['IdEquipe']){ 
                $this->teams[] = new Team($ligne['IdEquipe'],$ligne['NomE'], $ligne['NbPointsE'],$ligne['IdEcurie'],$ligne['IdJeu']);
                $last = $ligne['IdEquipe'];
                $index+=1;
            }
        }
    }
}