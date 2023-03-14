<?php
require_once("./dao/ArbitratorDAO.php");
//create a match
class MatchJ
{
    private int $number;
    private string $date;
    private string $hour;
    private array $teams = array();
    private array $scores = array();
    private $dao;
    //constructor
    function __construct(int $number,string $date,string $hour){
        $this->number = $number;
        $this->date = $date;
        $this->hour = $hour;
        $this->dao= new ArbitratorDAO();
    }
    //add score of a team
    public function addteamscore(Team $team,int $score):void{
        $this->scores[$team->getId()] = $score;
        $this->teams[$team->getId()] = $team;
    }
    //initialize score of a team
    public function setteamscore(int $teamId,int $score):void{
        $this->scores[$teamId] = $score;
    }
    //get ID tournament by his id pool
    public static function getIdTournamentByPool(int $idPool) : int{
        $dao=new ArbitratorDAO();
        return $dao->selectIdTournoiByPool($idPool);
    }
    //get ID game by his id pool
    public static function getIdGameByPool(int $idPool): int{
        $dao=new ArbitratorDAO();
        return $dao->selectIdJeuByPool($idPool);
    }
    // know if score is isset or not
    public function isScoreSet():bool
    {
        foreach($this->scores as $score){
            if($score == null){
                return false;
            }
        }
        return true;
    }
    //know who won the match
    public function winnerTeam():Team
    {
        $t = array_keys($this->teams);
        if($this->scores[$t[0]] > $this->scores[$t[1]]){
            return $this->teams[$t[0]];
        }else if($this->scores[$t[0]] == $this->scores[$t[1]]){
            return new Team(0,"X",0,0,0);
        } else {
            return $this->teams[$t[1]];
        }
    }
    //get teams of a match
    public function getTeams(): array
    {
        return $this->teams;
    }
    //initialize the score
    public static function setScore(array $pools, int $idPool,int $idTeam1,int $idTeam2 ,int $score1,int $score2):void
    {
        $dao=new ArbitratorDAO();
        $number= $dao->selectNumberOfPool($idPool,$idTeam1,$idTeam2)[0];
        $pools[$idPool]->setScoreMatch($number, $idTeam1, $idTeam2, $score1, $score2);
        $dao->updateTeamScoreOnMatch($idPool,$idTeam1,$score1,$number);
        $dao->updateTeamScoreOnMatch($idPool,$idTeam2,$score2,$number);
        //get id tournoi et id jeu
        $idT = MatchJ::getIdTournamentByPool($idPool);
        $idJ = MatchJ::getIdGameByPool($idPool);
        $PoolFinaleExiste = false;
        $cmpt = 0;
        //si c'est la Pool finale on vérifie si tous les scores sont initialisés
       foreach($pools as $Pool){
           if($Pool->isPoolFinale()){
                $PoolFinaleExiste = true;
                if($Pool->checkIfAllScoreSet()){
                    Tournament::updatePointsTournament($idT, $idJ);
                }
           }
           // sinon on vérifie si tous les scores sont initialisés et on ajoute 1 a cmpt
           else if($Pool->checkIfAllScoreSet()){
                $cmpt++;
           }
        }
        if(!$PoolFinaleExiste && $cmpt == 4){
            Tournament::generateFinalPool($idT, $idJ);
        }
    }
    public function getScores(): array
    {
        return $this->scores;
    }
}
?>