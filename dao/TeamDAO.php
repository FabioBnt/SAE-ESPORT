<?php 
//create a team dao
class TeamDAO extends DAO {
    //constructor
    public function __construct() {
        parent::__construct();
    }
    //select tournaments where a team played
    public function selectTournamentsForTeam($idEquipe=null, $idGame=null){
        $sql = '';
        if($idGame != null){
            // TODO:  add date limite inscription
                $sql = "select T.IdTournoi, T.NomTournoi, T.CashPrize, T.Notoriete, T.Lieu, T.DateHeureTournois,
                J.IdJeu, J.NomJeu, J.TypeJeu, J.TempsDeJeu, J.DateLimiteInscription FROM Tournois T, Contenir C, Game J where C.IdJeu = J.IdJeu
                AND C.IdTournoi = T.IdTournoi AND  J.IdJeu='".$idGame."' 
                AND T.IdTournoi not in (select DISTINCT T.IdTournoi from Tournois T, Contenir C, Game J , Equipe E, Participer P where C.IdJeu = J.IdJeu
                AND C.IdTournoi = T.IdTournoi AND T.IdTournoi=P.IdTournoi AND P.IdEquipe=E.IdEquipe AND E.IdJeu=J.IdJeu AND E.IdEquipe='".$idEquipe."')";
        }else{
            $sql = "select T.IdTournoi, T.NomTournoi, T.CashPrize, T.Notoriete, T.Lieu, T.DateHeureTournois,
            J.IdJeu, J.NomJeu, J.TypeJeu, J.TempsDeJeu, J.DateLimiteInscription FROM Tournois T, Contenir C, Game J , Equipe E, Participer P where C.IdJeu = J.IdJeu
            AND C.IdTournoi = T.IdTournoi AND T.IdTournoi=P.IdTournoi AND P.IdEquipe=E.IdEquipe AND E.IdJeu=J.IdJeu AND E.IdEquipe=".$idEquipe.' ORDER BY IdTournoi';
        }
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select tournament ".$e->getMessage(), 1);
        }
     }
     //get id by name for a team
    public function selectIDbyNameTeam($name){
        $sql = "SELECT E.IdEquipe FROM Team E WHERE E.nomE = $name";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            $data= $result->fetchAll();
            return $data[0]['IdEquipe'];
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select id by name team ".$e->getMessage(), 1);
        }
    }
    //select name of the game by id
    public function selectGameName($id){
        $sql = "SELECT J.NomJeu FROM Game J WHERE J.IdJeu=$id";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            $data= $result->fetchAll();
            return $data[0]['NomJeu'];
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select game name by id ".$e->getMessage(), 1);
        }
    }
    //select team of a tournament and return a boolean
    public function TeamOnTournament(Tournoi $tournoi,$idT): bool
    {
        $sql = "SELECT count(*) as total FROM Participer WHERE IdTournoi =".$tournoi->getIdTournoi()." AND IdTeam =$idT";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            $data= $result->fetchAll();
            return $data[0]['total'] > 0;
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select team on tournament ".$e->getMessage(), 1);
        }
    }
    //select team by his id
    public static function selectTeamByID($id): Team
    {
        $Team=null;
        $sql = "SELECT * FROM Equipe e, Game j WHERE IdEquipe =$id AND j.Idgame = e.Idgame";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            $data= $result->fetchAll();
            foreach($data as $ligneE){
                $Team = new Team($ligneE['IdTeam'], $ligneE['nameE'], $ligneE['NbPointsE'], $ligneE['IDEcurie'], 
                new game($ligneE['Idgame'],$ligneE['namegame'], $ligneE['Typegame'], $ligneE['TempsDegame'], $ligneE['DateLimiteInscription']));
            }
            return $Team;
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select team by id ".$e->getMessage(), 1);
        }
    }
    //select players of a team by his id
    public function selectPlayers($id)
    {
        $sql = "SELECT Pseudo,Nationalite FROM Joueur WHERE IdTeam =$id";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();;
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select players ".$e->getMessage(), 1);
        }
    }
    //insert a team on a tournament
    public function insertTeamTournament($idTournament,$idTeam){
        $sql = "INSERT INTO Participer  (IdTournoi, IdTeam) VALUES (:idtournoi,:idteam)";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute(array($idTournament,$idTeam));
        }catch(PDOException $e){
            throw new Exception("Error Processing insert team ".$e->getMessage(), 1);
        }
    }
    // select mysql for a team list - on a ecurie
    public function selectTeam($id=null){
        if(is_null($id)){
            $sql = "SELECT * FROM Team E ORDER BY IdJeu";
        } else {
            $sql = "SELECT * FROM Team E where E.IdEcurie=$id ORDER BY IdJeu";
        }
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select team list ".$e->getMessage(), 1);
        }
    }
}