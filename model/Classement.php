<?php
require_once("./dao/UserDAO.php");
require_once ("./model/Game.php");
//create a classement
class Classement
{
    private game $game;
    public array $classement = array();
    //constructor
    public function __construct(game $game){
        $this->game = $game;
    }
    //get game of the classement
    public function getGame(): game
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
        $db = new UserDAO();
        $this->classement = array();
        $data = $db->selectRanking($idGame);
        foreach($data as $ligne){
            $this->classement[] = $ligne;
        }
        return  $this->classement;
    }
}