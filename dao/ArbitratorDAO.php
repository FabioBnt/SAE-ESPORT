<?php 
class ArbitratorDAO extends DAO {
    public function __construct() {
        parent::__construct();
    }
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
    public function selectTournamentPool($idGame, $idTournament){
        $mysql = parent::getConnection();
        $sql = "SELECT IdPoule FROM Poule WHERE IdJeu = :idJeu AND IdTournoi = :idTournoi";
        $stmt = $mysql->prepare($sql);
        $stmt->execute(array(':idJeu' => $idGame, ':idTournoi' => $idTournament));
        return $stmt->fetchAll();
    }
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
    public function insertParticipantPool($idPool, $idTeam){
        $mysql = parent::getConnection();
        $sql = "INSERT INTO Faire_partie (IdPoule, IdEquipe) VALUES (:idPoule, :idEquipe)";
        $stmt = $mysql->prepare($sql);
        // pass an array of values to the execute method
        return $stmt->execute(
            array(':idPoule' => $idPool,
                ':idEquipe' => $idTeam));
    }

    /*$this->arbitratorDao->insertParticipantPoolMatch($key, $value[0], $value[1], $n){
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[0], $key, $n, NULL));  
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[1], $key, $n, NULL));
                $n++;}
    */
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

}
?>