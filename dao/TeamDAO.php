<?php 
require_once('./dao/DAO.php');
//create a team dao
class TeamDAO extends DAO {
    private PDO $mysql;
    //constructor
    public function __construct() {
        $this->mysql= self::getInstance()->getConnection();
    }
    //select tournaments where a team played
    public function selectTournamentsForTeam(string $idTeam=null,string $idGame=null,string $dateT=null):array{
        $sql = '';
        if($idGame !== null && $dateT !== null){
                $sql = "SELECT T.IdTournoi, T.NomTournoi, T.CashPrize, T.Notoriete, T.Lieu, T.DateHeureTournois,
                J.IdJeu, J.NomJeu, J.TypeJeu, J.TempsDeJeu, J.DateLimiteInscription FROM Tournois T, Contenir C, Jeu J where C.IdJeu = J.IdJeu
                AND C.IdTournoi = T.IdTournoi AND  J.IdJeu='$idGame' AND T.DateHeureTournois > '$dateT'
                AND T.IdTournoi not in (select DISTINCT T.IdTournoi from Tournois T, Contenir C, Jeu J , Equipe E, Participer P where C.IdJeu = J.IdJeu
                AND C.IdTournoi = T.IdTournoi AND T.IdTournoi=P.IdTournoi AND P.IdEquipe=E.IdEquipe AND E.IdJeu=J.IdJeu AND E.IdEquipe='$idTeam')";
        }else{
            $sql = "SELECT T.IdTournoi, T.NomTournoi, T.CashPrize, T.Notoriete, T.Lieu, T.DateHeureTournois,
            J.IdJeu, J.NomJeu, J.TypeJeu, J.TempsDeJeu, J.DateLimiteInscription FROM Tournois T, Contenir C, Jeu J , Equipe E, Participer P where C.IdJeu = J.IdJeu
            AND C.IdTournoi = T.IdTournoi AND T.IdTournoi=P.IdTournoi AND P.IdEquipe=E.IdEquipe AND E.IdJeu=J.IdJeu AND E.IdEquipe='$idTeam' ORDER BY 1";
        }
        try{
            return $this->mysql->query($sql)->fetchAll();
        }catch(PDOException $e){
            throw new RuntimeException('Error Processing Request select tournament ' .$e->getMessage(), 1);
        }
     }
     //get id by name for a team
    public function selectIDbyNameTeam(string $name):int{
        $sql = "SELECT IdEquipe FROM Equipe WHERE NomCompte ='$name'";
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            $data= $result->fetchAll();
            return (int)$data[0]['IdEquipe'];
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select id by name team ' .$e->getMessage(), 1);
        }
    }
    //select name of the game by id
    public function selectGameName(int $id):string{
        $sql = "SELECT J.NomJeu FROM Jeu J WHERE J.IdJeu=$id";
        try{
            $result = $this->mysql->query($sql);
            $data= $result->fetchAll();
            return $data[0]['NomJeu'];
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select game name by id ' .$e->getMessage(), 1);
        }
    }
    //select team of a tournament and return a boolean
    public function TeamOnTournament(Tournament $tournament,int $idT): bool
    {
        $sql = 'SELECT count(*) as total FROM Participer WHERE IdTournoi =' .$tournament->getIdTournament()." AND IdEquipe =$idT";
        try{
            $result = $this->mysql->query($sql);
            $data= $result->fetchAll();
            return $data[0]['total'] > 0;
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select team on tournament ' .$e->getMessage(), 1);
        }
    }
    //select team by his id
    public function selectTeamByID(string $id): Team
    {
        $Team=null;
        $sql = "SELECT * FROM Equipe e, Jeu j WHERE IdEquipe ='$id' AND j.IdJeu = e.IdJeu";
        try{
            $result = $this->mysql->query($sql);
            $data= $result->fetchAll();
            foreach($data as $ligneE){
                $Team = new Team($ligneE['IdEquipe'], $ligneE['NomE'], $ligneE['NbPointsE'], $ligneE['IDEcurie'],$ligneE['IdJeu']);
            }
            return $Team;
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select team by id ' .$e->getMessage(), 1);
        }
    }
    //select players of a team by his id
    public function selectPlayers(string $id):array
    {
        $sql = "SELECT Pseudo,Nationalite FROM Joueur WHERE IdEquipe =$id";
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select players ' .$e->getMessage(), 1);
        }
    }
    //insert a team on a tournament
    public function insertTeamTournament(int $idTournament,int $idTeam):string{
        $sql = "INSERT INTO Participer (IdTournoi,IdEquipe) VALUES ('$idTournament','$idTeam')";
        try{
            return $this->mysql->prepare($sql)->execute();
        }catch(PDOException $e){
            throw new \RuntimeException('Error Processing insert team ' .$e->getMessage(), 1);
        }
    }
    // select mysql for a team list - on a Organization
    public function selectTeam(int $id=null):array{
        if(is_null($id)){
            $sql = 'SELECT * FROM Equipe E ORDER BY IdJeu';
        } else {
            $sql = "SELECT * FROM Equipe E where E.IdEcurie=$id ORDER BY IdJeu";
        }
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select team list ' .$e->getMessage(), 1);
        }
    }
    //select team by his account name
    public function selectTeamIDByAccountName(string $accountName):array
    {
        $sql = "SELECT * FROM Equipe E where E.NomCompte='$accountName'";
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select players ' .$e->getMessage(), 1);
        }
    }
    //select cashprize by id tournament
    public function countNumberTeamByGame(int $idG):array{
        $sql = "SELECT count(*) as total FROM Equipe WHERE IdJeu=$idG";
        try{
            return $this->mysql->query($sql)->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
    //select id team by game
    public function selectTeamIdByGame(int $idG):array{
        $sql = "SELECT IdEquipe FROM Equipe WHERE IdJeu=$idG";
        try{
            return $this->mysql->query($sql)->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
}