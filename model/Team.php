<?php
require_once ("./model/Connection.php");
require_once ("./model/Organization.php");
require_once ("./dao/TeamDAO.php");
require_once ("./dao/UserDAO.php");
require_once ("./model/Role.php");
//create a team
class Team
{
    private int $id;
    private string $name;
    private int $points;
    private string $Organization;
    private game $game;
    private array $teams;
    /**
     * @param $id
     * @param $name
     * @param $points
     * @param $Organization
     * @param $game
     */
    //constructor
    public function __construct(int $id=null,string $name=null,int $points=null,string $Organization=null,game $game=null){
        $this->id =$id;
        $this->name = $name;
        $this->points = $points;
        $this->Organization = $Organization;
        $this->game = $game;
        $this->teams = array();
    }
    /**
     * @return bool
     */
    //savoir si l'équipe est connectée
    public function isConnected(): bool
    {
        return (Connection::getInstanceWithoutSession()->IfgetRoleConnection(Role::Team) || Connection::getInstance()->IfgetRoleConnection(Role::Team));
    }
    /**
     * @param Tournament $tournament
     * @return int
     */
    //get id of a team by his name
    public static function getIDbyname(string $name) : int {
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
        return $this->game->getId();
    }
    //get organization name of the team
    public function getOrganization() : string{
        return Organization::getOrganization($this->Organization)->getDesignation();
    }
    /**
     * @param Tournament $tournament
     * @return bool
     */
    //know if team participate of the x tournament
    public function getIfTeamOnTournament(Tournament $tournament): bool
    {
        $dao= new TeamDAO();
        return $dao->TeamOnTournament($tournament,$this->id);
    }
    /**
     * @param $id
     * @return Team
     */
    //get team by his id
    public static function getTeam(int $id): Team
    {
        $dao= new TeamDAO();
        return $dao->selectTeamByID($id);
    }
    //get players of a id team
    public function getPlayers(int $id):array
    {
        $dao= new TeamDAO();
        return $dao->selectPlayers($id);
    }
    //get nb match win by the team
    public function getNbmatchWin(): int
    {
        $listeTournois = new Tournament();
        $listeTournois->tournamentsParticipatedByTeam($this->id);
        $nb=0;
        foreach($listeTournois->allTournaments() as $tournament){
            $t=$tournament->getPools();
            $n = null;
            if ($this->game instanceof game) {
                $n = $this->game->getId();
            }else{
                $n = $this->game - '0';
            }
            if(array_key_exists($n,$t)){
                foreach($t[$n] as $Pool){
                    if($Pool->isPoolFinale()==='1'){
                        if($Pool->meilleureTeam()->getId()===$this->id){
                            $nb++;
                        }
                    }
                }
            }
        }
        return $nb;
    }
    //cashprize win by the team
    public function sumTournamentWin():int{
        $listeTournois = new Tournament();
        $listeTournois->tournamentsParticipatedByTeam($this->id);
        $nb=0;
        foreach($listeTournois->allTournaments() as $tournament){
            $t=$tournament->getPools();
            $n = null; 
            if ($this->game instanceof game) {
                $n = $this->game;
            }else{
                $n = $this->game - '0';
            }
            if(array_key_exists($n,$t)){
                foreach($t[$n] as $Pool){
                    if($Pool->isPoolFinale()==='1'){
                        if($Pool->meilleureTeam()->getId()===$this->id){
                            $dao= new UserDAO();
                            $res= $dao->selectCashPrizeById($t->getId());
                            $nb += $res[0]['CashPrize'];
                        }
                    }
                }
            }
        }
        return $nb;
    }
    //register a team to a tournament
    public function register(Tournament $tournament): int
    {
        if(!$this->isConnected()){
            throw new \RuntimeException('action qui nécessite une Connection en tant que membre du groupe');
        }
        $nbParti = $tournament->getNumberParticipant($this->game->getId());
        if($nbParti ===16){
            throw new \RuntimeException('tournoi complet');
        }
        if(!$tournament->haveGame($this->game->getId())){
            throw new \RuntimeException('L\'équipe n\'est pas expert dans les gamex du tournoi');
        }
        if(strtotime($tournament->getregisterDeadline()) > strtotime(date("Y/m/d"))){
            throw new \RuntimeException('L\'inscription est fermée pour ce tournoi');
        }
        if($this->getIfTeamOnTournament($tournament)){
            throw new \RuntimeException('Déjà inscrit');
        }
        $dao= new TeamDAO();
        $dao->insertTeamTournament($tournament->getIdTournament(), $this->id);
        $nbParti++;
        if($nbParti === 16){
            $tournament->generatePools($this->game->getId());
        }
        return 1;
    }
    // TEAMS //
    // get team list
    public function getTeamList(int $id=null):array{
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
    //get team by his id
    public static function getTeamIDByAccountName(int $id):int
    {
        $dao= new TeamDAO();
        return $dao->selectTeamIDByAccountName($id)[0];
    }
}