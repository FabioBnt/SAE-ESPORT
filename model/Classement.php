<?php
require_once("./dao/UserDAO.php");
require_once ("./model/Game.php");
//create a classement
class Classement
{
    private int $game;
    public array $classement = array();
    private $dao;
    //constructor
    public function __construct(int $game){
        $this->game = $game;
        $this->dao = new UserDAO();
    }
    //get game of the classement
    public function getGame(): int
    {
        return $this->game;
    }
    //get the classement
    public function getClassement(): array
    {
        return $this->classement;
    }
    //get tournament classement for a game id
    public function returnRanking(int $idGame): array
    {
        $this->classement = array();
        $data = $this->dao->selectRanking($idGame);
        foreach($data as $ligne){
            $this->classement[] = $ligne;
        }
        return  $this->classement;
    }
}