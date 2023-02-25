<?php
require_once("./dao/UserDAO.php");
//create a game
class Game
{
    private int $id;
    private string $name;
    private string $type;
    private string $time;
    private string $registerLimit;
    //constructor
    public function __construct(int $id=0,string $name="",string $type="",string $time="",string $registerLimit=""){
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->time = $time;
        $this->registerLimit = date($registerLimit);
    }
    //get Id of a game
    public function getId():string{
        return $this->id;
    }
    //get registerlimit of a game
    public function getregisterlimit():string{
        return $this->registerLimit;
    }
    //get name of a game
    public function getname():string{
        return $this->name;
    }
    //get type of a game
    public function gettype():string{
        return $this->type;
    }
    //get time of a game
    public function gettime():string{
        return $this->time;
    }
    //get all games
    public static function allGames():array
    {
        $data = new UserDAO();
        $data = $data->selectAllGames();
        $jeux = array();
        foreach($data as $ligne){
            $jeux[] = new Game($ligne['IdJeu'],$ligne['nomJeu'], $ligne['TypeJeu'], $ligne['tempsDeJeu'], $ligne['DateLimiteInscription']);
        }
        return ($jeux);
    }
    //get game by id
    public static function getGameById($idGame):Game {
        $dao= new UserDAO();
        return $dao->selectGameById($idGame);
    }
    //get game for organization not create
    public static function getGameTeamNotPlayed($idOrga):array
    {
        $dao= new UserDAO();
        return $dao->selectGameTeamNotPlayed($idOrga);
    }
}
?>