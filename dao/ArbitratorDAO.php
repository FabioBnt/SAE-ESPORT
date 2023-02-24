<?php 
//create an arbitrator dao class
class ArbitratorDAO extends DAO {
    //constructor
    public function __construct() {
        parent::__construct();
    }
    //insert pool of a tournament for a game
    public function insertTournamentPool($numberPool, $isFinalPool, $idGame, $idTournament) {
        $mysql = parent::getConnection();
        $sql = "INSERT INTO Poule (NumeroPoule, EstPouleFinale, IdJeu, IdTournoi) VALUES (:numeroPoule, :estPouleFinale, :idJeu, :idTournoi)";
        $stmt = $mysql->prepare($sql);
        // pass an array of values to the execute method
        return $stmt->execute(
            array(':numeroPoule' => $numberPool,
                ':estPouleFinale' => $isFinalPool,
                ':idJeu' => $idGame,
                ':idTournoi' => $idTournament));
    }
    //select tournament pool by game and id tournament
    public function selectTournamentPool($idGame, $idTournament){
        $mysql = parent::getConnection();
        $sql = "SELECT IdPoule FROM Poule WHERE IdJeu = :idJeu AND IdTournoi = :idTournoi";
        $stmt = $mysql->prepare($sql);
        $stmt->execute(array(':idJeu' => $idGame, ':idTournoi' => $idTournament));
        return $stmt->fetchAll();
    }
    //insert match of a pool
    public function insertPoolMatch($idPool, $numberM, $dateM, $hourM){
        $mysql = parent::getConnection();
        $sql = "INSERT INTO MatchJ (IdPoule, Numero, dateM, HeureM) VALUES (:idPoule, :Numero, :dateM, :heureM)";
        $stmt = $mysql->prepare($sql);
        // pass an array of values to the execute method
        return $stmt->execute(
            array(':idPoule' => $idPool,
                ':numero' => $numberM,
                ':dateM' => $dateM,
                ':heureM' => $hourM));
    }
    //insert particpant of a pool
    public function insertParticipantPool($idPool, $idTeam){
        $mysql = parent::getConnection();
        $sql = "INSERT INTO Faire_partie (IdPoule, IdEquipe) VALUES (:idPoule, :idEquipe)";
        $stmt = $mysql->prepare($sql);
        // pass an array of values to the execute method
        return $stmt->execute(
            array(':idPoule' => $idPool,
                ':idEquipe' => $idTeam));
    }
    //insert participant of a match on a pool
    public function insertParticipantPoolMatch($idPool, $idTeam, $idTeam2, $numberM){
        $mysql = parent::getConnection();
        $sql = "INSERT INTO Concourir (IdEquipe, IdPoule, Numero, Score) VALUES (:idEquipe, :idPoule, :numero, :score)";
        $stmt = $mysql->prepare($sql);
        // pass an array of values to the execute method
        return ($stmt->execute(
            array(':idEquipe' => $idTeam,
                ':idPoule' => $idPool,
                ':numero' => $numberM,
                ':score' => NULL))
        && $stmt->execute(
            array(':idEquipe' => $idTeam2,
                ':idPoule' => $idPool,
                ':numero' => $numberM,
                ':score' => NULL)));
    }
    //update points of a team
    public function updateTeamPoints($points, $idTeam){
        $mysql = parent::getConnection();
        $sql = "UPDATE Equipe SET NbPointsE = NbPointsE + :points WHERE IdEquipe = :idEquipe";
        $stmt = $mysql->prepare($sql);
        // pass an array of values to the execute method
        return $stmt->execute(
            array(':points' => $points,
                ':idEquipe' => $idTeam));
    }
    //initialise points of a team
    public function setTeamPoints($points, $idTeam){
        $mysql = parent::getConnection();
        $sql = "UPDATE Equipe SET NbPointsE = :points WHERE IdEquipe = :idEquipe";
        $stmt = $mysql->prepare($sql);
        // pass an array of values to the execute method
        return $stmt->execute(
            array(':points' => $points,
                ':idEquipe' => $idTeam));
    }
    //select ID tournament by his id pool
    public function selectIdTournoiByPool($idPool) : int{
        $sql = "SELECT IdTournoi FROM Poule WHERE IdPoule =$idPool";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            $data = $result->fetchAll();
            return  $data[0]['IdTournoi'];
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select players ".$e->getMessage(), 1);
        }
    }
    //select id game by id pool
    public function selectIdJeuByPool($idPool): int{
        $sql = "SELECT IdJeu FROM Poule WHERE IdPoule =$idPool";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            $data = $result->fetchAll();
            return  $data[0]['IdJeu'];
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select players ".$e->getMessage(), 1);
        }
    }
    //select number of the pool by id pool and id team
    public function selectNumberOfPool($idPool,$idTeam1,$idTeam2){
        $sql = "SELECT number FROM Concourir WHERE IdPoule = $idPool AND IdTeam = $idTeam1 AND number in
        (SELECT number FROM Concourir WHERE IdPoule = $idPool AND IdTeam = $idTeam2)";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            $data = $result->fetchAll();
            return  $data[0]['number'];
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select players ".$e->getMessage(), 1);
        }
    }
    //update score of a team on a match
    public function updateTeamScoreOnMatch($idPool,$idTeam,$score,$number){
        $mysql = parent::getConnection();
        $sql = "UPDATE Concourir SET Score = :score WHERE IdPoule = :IdPoule AND IdEquipe = :IdEquipe AND numero = :numero";
        $stmt = $mysql->prepare($sql);
        // pass an array of values to the execute method
        return $stmt->execute(
            array(':score' => $score,
                ':IdPoule' => $idPool,
                ':IdEquipe' => $idTeam,
                ':numero' => $number));
    }
    //add a match on a pool
    public function addMatch($idPool,$number)
    {
        $sql = "SELECT * FROM Concourir WHERE IdPoule = $idPool AND numero=$number";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select players ".$e->getMessage(), 1);
        }
    }
    //select sum score of a team for a pool
    public function SumScoreTeam($idPool,$idTeam)
    {
        $sql = "SELECT SUM(Score) as scoreS FROM Concourir WHERE IdPoule = $idPool AND IdEquipe=$idTeam";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            $data = $result->fetchAll();
            return $data[0]['scoreS'];
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select players ".$e->getMessage(), 1);
        }
    }
    //select team of a pool
    public function TeamOfPool($idPool)
    {
        $sql = "SELECT IdEquipe FROM Faire_partie WHERE IdPoule = $idPool";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select players ".$e->getMessage(), 1);
        }
    }
}
?>