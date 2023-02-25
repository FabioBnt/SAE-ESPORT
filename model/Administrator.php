<?php
require_once ("./dao/AdminDAO.php");
//Create an administrator
class Administrator {
    private $dao;
    //constructor
    public function __construct(){
        $this->dao= new AdminDAO();
    }
    //create an organization on db
    public function createOrganization(string $name, string $account, string $pwd, string $type):string
    {
        return $this->dao->insertOrganization($name,$account,$pwd,$type);
    }
    //create a tournament on db
    public function createTournament(string $name, int $cashPrize, string $notoriety, string $city, string $startingHour, string $date, array $games):string{
        return $this->dao->insertTournament($name,$cashPrize,$notoriety,$city,$startingHour,$date,$games);
    }
}