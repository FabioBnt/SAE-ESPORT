<?php 
require_once('./dao/DAO.php');
//create an arbitrator dao class
class ArbitratorDAO extends DAO {
    private PDO $mysql;
    //constructor
    public function __construct() {
        $this->mysql=parent::getInstance()->getConnection();
    }
    //insert pool of a tournament for a game
    public function insertTournamentPool(int $numberPool,bool $isFinalPool,int $idGame,int $idTournament):string {
        try {
            $sql = 'INSERT INTO Poule (NumeroPoule, EstPouleFinale, IdJeu, IdTournoi) VALUES (:numeroPoule, :estPouleFinale, :idJeu, :idTournoi)';
            $stmt = $this->mysql->prepare($sql);
            // pass an array of values to the execute method
            return $stmt->execute(
                array(':numeroPoule' => $numberPool,
                    ':estPouleFinale' => $isFinalPool,
                    ':idJeu' => $idGame,
                    ':idTournoi' => $idTournament));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //select tournament pool by game and id tournament
    public function selectTournamentPool(int $idGame,int $idTournament):array{
        $sql = 'SELECT IdPoule FROM Poule WHERE IdJeu = :idJeu AND IdTournoi = :idTournoi';
        try{
            $stmt = $this->mysql->prepare($sql);
            $stmt->execute(array(':idJeu' => $idGame, ':idTournoi' => $idTournament));
            return $stmt->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
    //insert match of a pool
    public function insertPoolMatch(int $idPool,int $numberM,string $dateM,string $hourM):string{
        try {
            $sql = 'INSERT INTO MatchJ (IdPoule, Numero, dateM, HeureM) VALUES (:idPoule, :Numero, :dateM, :heureM)';
            $stmt = $this->mysql->prepare($sql);
            // pass an array of values to the execute method
            return $stmt->execute(
                array(':idPoule' => $idPool,
                    ':numero' => $numberM,
                    ':dateM' => $dateM,
                    ':heureM' => $hourM));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //insert particpant of a pool
    public function insertParticipantPool(int $idPool,int $idTeam):string{
        $sql = 'INSERT INTO Faire_partie (IdPoule, IdEquipe) VALUES (:idPoule, :idEquipe)';
        try {
            $stmt = $this->mysql->prepare($sql);
            // pass an array of values to the execute method
            return $stmt->execute(
                array(':idPoule' => $idPool,
                    ':idEquipe' => $idTeam));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //insert participant of a match on a pool
    public function insertParticipantPoolMatch(int $idPool,int $idTeam,int $idTeam2,int $numberM):string{
        $sql = 'INSERT INTO Concourir (IdEquipe, IdPoule, Numero, Score) VALUES (:idEquipe, :idPoule, :numero, :score)';
        try {
            $stmt = $this->mysql->prepare($sql);
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
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //update points of a team
    public function updateTeamPoints(int $points,int $idTeam):string{
        $sql = 'UPDATE Equipe SET NbPointsE = NbPointsE + :points WHERE IdEquipe = :idEquipe';
        try {
            $stmt = $this->mysql->prepare($sql);
            // pass an array of values to the execute method
            return $stmt->execute(
                array(':points' => $points,
                    ':idEquipe' => $idTeam));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //initialise points of a team
    public function setTeamPoints(int $points,int $idTeam):string{
        $sql = 'UPDATE Equipe SET NbPointsE = :points WHERE IdEquipe = :idEquipe';
        try {
            $stmt = $this->mysql->prepare($sql);
            // pass an array of values to the execute method
            return $stmt->execute(
                array(':points' => $points,
                    ':idEquipe' => $idTeam));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //select ID tournament by his id pool
    public function selectIdTournoiByPool(int $idPool) : int{
        $sql = "SELECT IdTournoi FROM Poule WHERE IdPoule =$idPool";
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            $data = $result->fetchAll();
            return  $data[0]['IdTournoi'];
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select players ' .$e->getMessage(), 1);
        }
    }
    //select id game by id pool
    public function selectIdJeuByPool(int $idPool): int{
        $sql = "SELECT IdJeu FROM Poule WHERE IdPoule =$idPool";
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            $data = $result->fetchAll();
            return  $data[0]['IdJeu'];
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select players ' .$e->getMessage(), 1);
        }
    }
    //select number of the pool by id pool and id team
    public function selectNumberOfPool(int $idPool,int $idTeam1,int $idTeam2):array{
        $sql = "SELECT number FROM Concourir WHERE IdPoule = $idPool AND IdEquipe = $idTeam1 AND number in
        (SELECT number FROM Concourir WHERE IdPoule = $idPool AND IdEquipe = $idTeam2)";
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            $data = $result->fetchAll();
            return  $data[0]['number'];
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select players ' .$e->getMessage(), 1);
        }
    }
    //update score of a team on a match
    public function updateTeamScoreOnMatch(int $idPool,int $idTeam,int $score,int $number):string{
        $sql = 'UPDATE Concourir SET Score = :score WHERE IdPoule = :IdPoule AND IdEquipe = :IdEquipe AND numero = :numero';
        try {
            $stmt = $this->mysql->prepare($sql);
            // pass an array of values to the execute method
            return $stmt->execute(
                array(':score' => $score,
                    ':IdPoule' => $idPool,
                    ':IdEquipe' => $idTeam,
                    ':numero' => $number));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //add a match on a pool
    public function addMatch(int $idPool,int $number):array
    {
        $sql = "SELECT * FROM Concourir WHERE IdPoule = $idPool AND numero=$number";
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select players ' .$e->getMessage(), 1);
        }
    }
    //select sum score of a team for a pool
    public function SumScoreTeam(int $idPool,int $idTeam):int
    {
        $sql = "SELECT SUM(Score) as scoreS FROM Concourir WHERE IdPoule = $idPool AND IdEquipe=$idTeam";
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            $data = $result->fetchAll();
            return $data[0]['scoreS'];
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select players ' .$e->getMessage(), 1);
        }
    }
    //select team of a pool
    public function TeamOfPool(int $idPool):array
    {
        $sql = "SELECT IdEquipe FROM Faire_partie WHERE IdPoule = $idPool";
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select players ' .$e->getMessage(), 1);
        }
    }
    //select score of a team
    public function selectScoreOfaTeam(int $idPool,int $idTeam,int $number):array
    {
        $sql = "SELECT Score FROM Concourir WHERE IdPoule = $idPool AND IdEquipe = $idTeam and Numero = $number";
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select players ' .$e->getMessage(), 1);
        }
    }
}
?>