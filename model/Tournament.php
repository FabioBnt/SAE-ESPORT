<?php
require_once ("./dao/UserDAO.php");
require_once ("./dao/ArbitratorDAO.php");
require_once ("./dao/TeamDAO.php");
require_once ("./model/Pool.php");
require_once ("./model/Notoriety.php");
//comparator Team
function comparatorTeam(Team $e1, Team $e2):bool {
    return ($e1->getPoints() > $e2->getPoints());
}
//create Tournament
class Tournament
{
    private int $id;
    private string $name;
    private string $cashPrize;
    private string $Notoriety;
    private string $location;
    private string $registerDeadline;
    private $Pools = null;
    private array $games = array();
    private string $dateHour;
    private $userDao;
    private $arbitratorDao;
    private $teamDao;
    private array $tournaments;
    private array $posMap;
    //constructor
    public function __construct(int $id=0,string $name="",string $cashPrize="",string $Notoriety="",string $location="",string $datehour="now",array $idandGame=array("",null)){
        $this->id =$id;
        $this->name = $name;
        $this->cashPrize = $cashPrize;
        $this->Notoriety = $Notoriety;
        $this->location = $location;
        $this->dateHour = $datehour;
        $this->Pools = null;
        $this->games[$idandGame[0]] = $idandGame[1];
        $this->tournaments = array();
        $this->userDao = new UserDAO();
        $this->teamDao = new TeamDAO();
        $this->arbitratorDao = new ArbitratorDao();
        if($datehour != "now"){
            $this->calculateDeadline($datehour);        
        } else {
            $this->dateHour= time();
        }
    }
    //calculate dead line register
    private function calculateDeadline(string $hourDateStart): void
    {
        // on prend le numero de jours le plus grand entre les games de tournoi
        (int)$maxDay = reset($this->games)->getregisterlimit();
        foreach ($this->games as $game){
            (int)$days = $game->getregisterlimit();
            if($maxDay > $days){
                $maxDay = $days;
            }
        }
        $datetime = date_create($hourDateStart);
        $intervalDays = date_interval_create_from_date_string("$maxDay days");
        $this->registerDeadline = date_format(date_sub($datetime,$intervalDays),"d/m/y");
    }
    //verify creation of pools
    private function verifiyingPools($dateGame): void{
        if(strtotime($this->getregisterDeadline()) > strtotime(date("Y/m/d")) &&
         strtotime($dateGame) < strtotime(date("Y/m/d"))){
            foreach($this->games as $game){
                if($this->getNumberPools($game->getId()) < 4){
                    $this->generatePools($game->getId());
                }
            }
        }
    }
    //update tournaments list
    private function updateListOfTournaments(array $data):void{
        $this->tournaments = array();
        $this->posMap = array();
        $last = -1;
        $index = -1;
        foreach ($data as $ligne) {
            if($last != $ligne['IdTournoi']){ 
                $this->tournaments[] = new Tournament($ligne['IdTournoi'],$ligne['NomTournoi'], $ligne['CashPrize'],
                $ligne['Notoriete'], $ligne['Lieu'], $ligne['DateHeureTournois'], 
                array($ligne['IdJeu'], new Game($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription'])));
                $last = $ligne['IdTournoi'];
                $index+=1;
            }else{
                $this->tournaments[$this->posMap[$ligne['IdTournoi']]]->addGame($ligne['IdJeu'],new Game($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']));
            }
            $this->posMap[$ligne['IdTournoi']] =  $index;
        }
    }
    //get all tournaments
    public function allTournaments():array
    {
        $this->updateListOfTournaments($this->userDao->selectTournaments());
        return $this->tournaments;
    }
    //get tournaments of a team
    public function tournamentsParticipatedByTeam(string $idEquipe):array
    {
        $this->updateListOfTournaments($this->teamDao->selectTournamentsForTeam($idEquipe));
        return $this->tournaments;
    }
    //get tournaments not played by a team for a game
    public function tournamentsSuggestedByTeam(int $idEquipe,int $idGame):array
    {
        $this->updateListOfTournaments($this->teamDao->selectTournamentsForTeam($idEquipe,$idGame,date('y-m-d H:i:s',time())));
        return $this->tournaments;
    }
    //get tournaments (filter)
    public function tournamentsFilter(string $gameName=null, string $tournamentName=null, float $minPrize=null, float $maxPrize=null, string $notoriety=null, string $city=null, string $dateTime=null):array
    { 
        $this->updateListOfTournaments($this->userDao->selectTournaments(null,$tournamentName, $minPrize, $maxPrize, $notoriety, $city, $dateTime, $gameName, null));
        return $this->tournaments;
    }
    //get tournament by id
    public function getTournament(int $id):Tournament{
        return $this->tournaments[$this->posMap[$id]];
    }
    //generate pool of a game
    public function generatePools(int $idgame): void
    {
        if(!array_key_exists($idgame, $this->games)){
            throw new Exception('Le jeu n\'appartient pas au tournoi');
        }
        $teams = $this->TeamsOfPoolParticipants($idgame);
        usort($teams, 'comparatorTeam');
        for($i = 1; $i < 5; $i++ ){
            $this->arbitratorDao->insertTournamentPool($i, 0, $idgame, $this->id);
        }
        $data = $this->arbitratorDao->selectTournamentPool($idgame, $this->id);
        $date = $this->dateHour;
        for($i = 0; $i < 6 ; $i++){
            $n = $i + 1;
            foreach($data as $ligne){
                $this->arbitratorDao->insertPoolMatch($ligne['IdPoule'], $n, date("d/m/y" ,strtotime($date)), date("h:m:s" ,strtotime($date)));           
            }
            $date = date('Y-m-d H:i:s', strtotime($date. ' + '.$n.' hours'));
        }
        $i = 0;
        $teamsPools = array();
        foreach($teams as $equipe){
            $i %= 4;
            $this->arbitratorDao->insertParticipantPool($data[$i]['IdPoule'], $equipe->getId());
            $teamsPools[$data[$i]['IdPoule']][] = $equipe->getId();
            $i++;
        }
        //insert matchs
        $this->insertConcourir($teamsPools);
    }
    //generate final pool
    public static function generateFinalPool(int $idT,int $idgame): void
    {
        // tournament
        $tournament = self::getTournament($idT);
        $teams =  $tournament->BestTeamPoolsNotFinal($idgame);
        $mysql = new ArbitratorDAO();
        $mysql->insertTournamentPool(5, 1, $idgame, $idT);
        $data = $mysql->selectTournamentPool($idgame, $idT);
        //day date
        $date = date("Y/m/d");
        for($i = 0; $i < 6 ; $i++){
            $n = $i + 1;
            foreach($data as $ligne){
                $mysql->insertPoolMatch($ligne['IdPoule'], $n, date("d/m/y" ,strtotime($date)), date("h:m:s" ,strtotime($date)));  
            }
            $date = date('Y-m-d H:i:s', strtotime($date. ' + '.$n.' hours'));
        }
        $teamsPools = array();
        foreach($teams as $equipe){
            $mysql->insertParticipantPool($data[0]['IdPoule'], $equipe->getId());
            $teamsPools[$data[0]['IdPoule']][] = $equipe->getId();
        }
        //insert matchs
        $tournament->insertConcourir($teamsPools);
    }
    // insert concourir fonction
    public function insertConcourir(array $teamsPools){
        foreach($teamsPools as $key => $value){
            $n = 1;
            while(count($value) < 4){
                $value[] = null;
            }
            if($value[0] && $value[1]){
                $this->arbitratorDao->insertParticipantPoolMatch($key, $value[0], $value[1], $n);
                $n++;
            }
            if($value[0] && $value[2]){
                $this->arbitratorDao->insertParticipantPoolMatch($key, $value[0], $value[2], $n);
                $n++;
            }
            if($value[0] && $value[3]){
                $this->arbitratorDao->insertParticipantPoolMatch($key, $value[0], $value[3], $n);
                $n++;
            }
            if($value[1] && $value[2]){
                $this->arbitratorDao->insertParticipantPoolMatch($key, $value[1], $value[2], $n); 
                $n++;
            }
            if($value[1] && $value[3]){
                $this->arbitratorDao->insertParticipantPoolMatch($key, $value[1], $value[3], $n);
                $n++;
            }
            if($value[2] && $value[3]){
                $this->arbitratorDao->insertParticipantPoolMatch($key, $value[2], $value[3], $n);
            }      
        }
    }
    //Recover the best teams of a game from the Pools (not final)
    public function BestTeamPoolsNotFinal(int $game):array
    {
        $teams = array();
        $Pools = $this->getPools()[$game];
        foreach($Pools as $Pool){
            $teams[] = $Pool->BestTeamOfPool();
        }
        return $teams;
    }
    //update points on tournament
    public static function updatePointsTournament(int $idT,int $idJ):void
    {
        // multiplier local 1 national 2 inter 3 only on final pool 100 60 30 10 for final pool 5 per match won
        $tournament = self::getTournament($idT);
        $Pools = $tournament->getPools();
        $Pools = $Pools[$idJ];
        $teams = array();
        $Poolfin = array();
        foreach($Pools as $Pool){
            if($Pool->isPoolFinale()){
                $Poolfin = $Pool;
                $teams = $Pool->classementTeams();
            }
        }
        $mysql = new ArbitratorDAO();
        // update table Team set score
        // multiplier local 1 national 2 inter 3 only on final pool 100 60 30 10 for final pool 5 per match won
        $multiplicateur = 0;
        if($tournament->getNotoriety() == Notoriety::Local){
            $multiplicateur = 1;
        }else if($tournament->getNotoriety() == Notoriety::Regional){
            $multiplicateur = 2;
        }else if($tournament->getNotoriety() == Notoriety::International){
            $multiplicateur = 3;
        }
        $i = 0;
        $scores = array(100, 60, 30, 10);
        foreach($teams as $key => $value){
            $points = ($scores[$i] * $multiplicateur + 5 * $value);
            $teams = $Poolfin->TeamsOfPool();
            $equipe = $teams[$key];
            if($equipe->getPoints() != null){
                $mysql->updateTeamPoints($points, $key);
            }
            else{
                $mysql->setTeamPoints($points, $key);
            }
            $i++;
            $i = $i % 4;
        }
    }
    //get name tournament
    public function getname():string{
        return $this->name;
    }
    //get notoriety tournament
    public function getNotoriety():string{
        return $this->Notoriety;
    }
    //get location tournament
    public function getlocation():string{
        return $this->location;
    }
    //get cashprize tournament
    public function getCashPrize():string{
        return $this->cashPrize;
    }
    //get date hour tournament
    public function getdateHour():string{
        return $this->dateHour;
    }
    //get games of tournament
    public function getgames():array{
        return $this->games;
    }
    //get date tournament
    public function getDate():string{
        return date("d/m/y" ,strtotime($this->dateHour));
    }
    //get hour tournament
    public function getHourStart():string{
        $datetime = new DateTime($this->dateHour);
        $datetime->setTimezone(new DateTimeZone('Europe/London'));
        return $datetime->format("H:i:s");
    }
    //get name of game of tournament
    public function namesgames(): string
    {
        $namegames ="";
        foreach($this->games as $game){
            $namegames.=$game->getname().', ';
        }
        $namegames = substr($namegames, 0, -2);
        return $namegames;
    }
    //add game on tournament
    public function addGame(int $id,Game $game):void{
        $this->games[$id] = $game;
    }
    //get id tournament
    public function getIdTournament():int{
        return $this->id;
    }
    //recover the registration deadline
    public function getregisterDeadline():string{
        return $this->registerDeadline;
    }
    //saw if the tournament contains a game
    public function haveGame(int $game):bool{
        foreach($this->games as $j){
            if($j->getId() == $game){
                return true;
            }
        }
        return false;
    }
    //returns the participating teams of the tournament
    public function TeamsOfPoolParticipants(int $idGame=null):array{
        $teams = array();
        $data = $this->userDao->selectParticipants($this->getIdTournament());
        foreach($data as $ligne){
            $dataE = $this->userDao->selectTeamGames($ligne['IdEquipe'],$idGame);
            foreach($dataE as $ligneM){
                $teams[$ligneM['IdEquipe']] = new Team($ligneM['IdEquipe'], $ligneM['NomE'], $ligneM['NbPointsE'], $ligneM['IDEcurie'],$ligneM['IdJeu']);
            }
        }
        return $teams;
    }
    //get pools
    public function getPools():array{
        $teams = $this->TeamsOfPoolParticipants();
        $this->Pools = array();
        $data = $this->userDao->selectTournamentPools($this->id);
        foreach($data as $ligne){
            $game=Game::getGameById($ligne['IdJeu']);
            $this->verifiyingPools($game->getdateLimit($this->getdateHour()));
            $this->Pools[$ligne['IdJeu']][$ligne['IdPoule']] = new Pool($ligne['IdPoule'], $ligne['NumeroPoule'],
             $ligne['EstPouleFinale'], $this->games[$ligne['IdJeu']]);
            $dataM = $this->userDao->selectTournamentPoolMatches($ligne['IdPoule']);
            foreach($dataM as $ligneM){
                $this->Pools[$ligne['IdJeu']][$ligne['IdPoule']]->addMatch($ligneM['Numero'], $ligneM['dateM'],
                 $ligneM['HeureM'],$teams);
            }
        }
        return $this->Pools;
    }
    //get number of participant
    public function getNumberParticipant(int $idgame):int{
        $data=$this->userDao->selectnumberParticipant($idgame,$this->getIdTournament());
        if(isset($data[0]) && $data[0] != null){
            return $data[0]['total']-'0';
        }else{
            return 0;
        }
    }
    //get number of pool
    public function getNumberPools(int $idgame):bool{
        $totalPools=$this->userDao->selectnumberPools($idgame,$this->getIdTournament());
        if(isset($totalPools[0]) && $totalPools[0] != null){
            return $totalPools[0]['total']-'0';
        }else{
            return 0;
        }
    }
}
?>