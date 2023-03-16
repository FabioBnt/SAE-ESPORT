<?php
require_once ('./model/Connection.php');
require_once ('./model/Organization.php');
require_once ('./dao/TeamDAO.php');
require_once ('./dao/UserDAO.php');
require_once ('./model/Role.php');
//create a team
class Team
{
    private int $id;
    private string $name;
    private $points;
    private string $Organization;
    private int $game;
    private array $teams;
    private $daoT;
    private $daoU;
    /**
     * @param $id
     * @param $name
     * @param $points
     * @param $Organization
     * @param $game
     */
    //constructor
    public function __construct(int $id=0, string $name= '', $points=null, string $Organization= '', int $game=0){
        $this->id =$id;
        $this->name = $name;
        $this->points = $points;
        $this->Organization = $Organization;
        $this->game = $game;
        $this->teams = array();
        $this->daoT= new TeamDAO();
        $this->daoU= new UserDAO();
    }
    /**
     * @return bool
     */
    //savoir si l'équipe est connectée
    public function isConnected($optional = null): bool
    {
        if ($optional === null){
            return (Connection::getInstance()->IfgetRoleConnection(Role::Team));
        }
        return (Connection::getInstanceWithoutSession()->IfgetRoleConnection(Role::Team));
    }
    /**
     * @param string $name
     * @return int
     * @throws Exception
     */
    //get id of a team by his name
    public static function getIDbyname(string $name) : int {
        $dao=new TeamDAO();
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
        if($this->points== ''){
            return 0;
        }
        return $this->points;
    }
    /**
     * @return string
     * @throws Exception
     */
    //get game name of the team by his id
    public function getGameName() : string
    {
        return $this->daoT->selectGameName($this->game);
    }
    //get id game of the team
    public function getgameId() : int
    {
        return $this->game;
    }
    //get organization name of the team
    public function getOrganization() : string{
        return Organization::getOrganization($this->Organization)->getDesignation();
    }
    /**
     * @param Tournament $tournament
     * @return bool
     * @throws Exception
     */
    //know if team participate of the x tournament
    public function getIfTeamOnTournament(Tournament $tournament): bool
    {
        return $this->daoT->TeamOnTournament($tournament,$this->id);
    }
    /**
     * @param string $id
     * @return Team
     * @throws Exception
     */
    //get team by his id
    public static function getTeam(string $id): Team
    {
        $dao= new TeamDAO();
        return $dao->selectTeamByID($id);
    }
    //get players of a id team

    /**
     * @throws Exception
     */
    public function getPlayers(string $id):array
    {
        return $this->daoT->selectPlayers($id);
    }
    //get nb match win by the team
    public function getNbmatchWin(): int
    {
        $listeTournois = new Tournament();
        $listeTournois =$listeTournois->tournamentsParticipatedByTeam($this->id);
        $nb=0;
        foreach($listeTournois as $tournament){
            $t=$tournament->getPools();
            $n = null;
            if ($this->game instanceof game) {
                $n = $this->game;
            }else{
                $n = $this->game - '0';
            }
            if(array_key_exists($n,$t)){
                foreach($t[$n] as $Pool){
                    if($Pool->isPoolFinal()==='1'){
                        if($Pool->BestTeamOfPool()->getId()===$this->id){
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
        $listeTournois =$listeTournois->tournamentsParticipatedByTeam($this->id);
        $nb=0;
        foreach($listeTournois as $tournament){
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
                        if($Pool->BestTeamOfPool()->getId()===$this->id){
                            $res= $this->daoU->selectCashPrizeById($t->getId());
                            $nb += $res[0]['CashPrize'];
                        }
                    }
                }
            }
        }
        return $nb;
    }
    //register a team to a tournament

    /**
     * @throws Exception
     */
    public function register(Tournament $tournament, $optional = null): int
    {
        if(!$this->isConnected($optional)){
            throw new RuntimeException('action qui nécessite une Connection en tant que membre du groupe');
        }
        $nbParti = $tournament->getNumberParticipant($this->game);
        if($nbParti ===16){
            throw new RuntimeException('tournoi complet');
        }
        if(!$tournament->haveGame($this->game)){
            throw new RuntimeException('L\'équipe n\'est pas expert dans les games du tournoi');
        }
        if(strtotime($tournament->getregisterDeadline()) > strtotime(date('Y/m/d'))){
            throw new RuntimeException('L\'inscription est fermée pour ce tournoi');
        }
        if($this->getIfTeamOnTournament($tournament)){
            throw new RuntimeException('Déjà inscrit');
        }
        $this->daoT->insertTeamTournament($tournament->getIdTournament(), $this->id);
        $nbParti++;
        if($nbParti === 16){
            $tournament->generatePools($this->game);
        }
        return 1;
    }
    // TEAMS //
    // get team list
    public function getTeamList(int $id=null):array{
        $data = $this->daoT->selectTeam($id);
        $this->updateTeamList($data);
        return $this->teams;
    }
    //mettre a jour la liste
    private function updateTeamList($data): void
    {
        $this->teams = array();
        $last = -1;
        $index = -1;
        foreach ($data as $ligne) {
            if($last !== $ligne['IdEquipe']){
                $this->teams[] = new Team($ligne['IdEquipe'],$ligne['NomE'], $ligne['NbPointsE'],$ligne['IDEcurie'],$ligne['IdJeu']);
                $last = $ligne['IdEquipe'];
                ++$index;
            }
        }
    }
    //get team by his id

    /**
     * @throws Exception
     */
    public static function getTeamIDByAccountName(string $accountName):int
    {
        $dao= new TeamDAO();
        return $dao->selectTeamIDByAccountName($accountName)[0]['IdEquipe'];
    }
}