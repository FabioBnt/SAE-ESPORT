<?php
require_once("./model/MatchJ.php");
require_once("./dao/ArbitratorDAO.php");
//create a Pool
class Pool
{
    private int $id;
    private int $number;
    private array $matchs = array();
    private int $isFinal;
    private int $game;
    private $dao;
    //constructor
    public function __construct(int $id,int $number,int $isFinal,int $game){
        $this->id = $id;
        $this->number = $number;
        $this->isFinal = $isFinal;
        $this->game = $game;
        $this->dao= new ArbitratorDAO();
    }
    //get id pool
    public function getId():int{
        return $this->id;
    }
    //get number of pool
    public function getnumber():int{
        return $this->number;
    }
    //know if pool is final or not
    public function isPoolFinal():int{
        return $this->isFinal;
    }
    //get matchs of a pool
    public function getMatchs(): array
    {
        return $this->matchs;
    }
    //add a match on a pool
    public function addMatch(int $number,string $date,string $hour,array $teams): void
    {
        $data= $this->dao->addMatch($this->id,$number);
        foreach($data as $ligne){
            $this->matchs[$number]->addEquipeScore($teams[$ligne['IdEquipe']], $ligne['Score']);
        }
    }
    //récupérer la meilleur équipe de la Pool
    public function BestTeamOfPool():Team{
        $teams = $this->TeamsOfPool();
            $best = null;
            $bestScore = -1;
            foreach ($teams as $team) {
                $score = $this->nbMatchsWin($team->getId()); //nb match gagnés
                if($score > $bestScore){
                    $best = $team;
                    $bestScore = $score;
                } else if($score == $bestScore){
                    $best=$this->getDiffPoint ($best,$team);
                }
            }
        return $best;
    }
    //récupérer la liste des meilleures équipes Top4
    public function BestTeams():array{
        $teams = $this->TeamsOfPool();
        $result = [];
        while (count($teams)>1 ) {
            $best = null;
            $bestScore = -1;
            foreach ($teams as $team) {
                $score = $this->nbMatchsWin($team->getId()); //nb match gagnés
                if($score > $bestScore){
                    $best = $team;
                    $bestScore = $score;
                } else if($score == $bestScore){
                    $best=$this->getDiffPoint ($best,$team);
                }
            }
            array_push($result, $best);
            unset($teams[array_search($best,$teams)]);
        }
        foreach ($teams as $team) {
            $p=$team->getId();
        }
        array_push($result,$teams[$p]);
        return $result;
    }
    //récupérer le classement des équipes
    public function classementTeams():array{
        $teams = $this->BestTeams();
        $classement = array();
        foreach ($teams as $team) {
            $classement[$team->getId()] = $this->nbMatchsWin($team->getId());
        }
        return $classement;
    }
    //recover the number of matches won by a team in the Pool
    public function nbMatchsWin(int $team): int
    {
        $nb = 0;
        foreach ($this->matchs as $match) {
            if($match->winnerTeam()->getId() == $team){
                $nb++;
            }
        }
        return $nb;
    }
    //get teams of pool
    public function TeamsOfPool():array{
        $data= $this->dao->TeamOfPool($this->id);
        $teams = array();
        foreach($data as $ligne){
            $teams[$ligne['IdEquipe']] = Team::getTeam($ligne['IdEquipe']);
        }
        return $teams;
    }
    //inputs 2 team ids from the same pool and outputs the id of the team with the most points
    public function getDiffPoint (Team $n1,Team $n2) {
        $e1=$n1->getId();
        $e2=$n2->getId();
        $g1= $this->dao->SumScoreTeam($this->id,$e1);
        $g2= $this->dao->SumScoreTeam($this->id,$e2);
        //ID1 a gagné le plus de match ou égalité 
        if($g1 >= $g2){
            return $n1;
        //ID2 a gagné le plus de match
        } else {
            return $n2;
        }
    }
    // check if all score isset
    public function checkIfAllScoreSet(): bool
    {
        foreach ($this->matchs as $match) {
            if(!$match->isScoreSet()){
                return false;
            }
        }
        return true;
    }
    //initialize match
    public function setScoreMatch(int $number,int $idTeam1,int $idTeam2,int $score1,int $score2): void
    {
        $this->matchs[$number]->setEquipeScore($idTeam1, $score1);
        $this->matchs[$number]->setEquipeScore($idTeam2, $score2);
    }
}
?>