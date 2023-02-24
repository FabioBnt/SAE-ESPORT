<?php
//create a user dao class
class UserDAO extends DAO{
    //constructor
    public function __construct(){
        parent::__construct();
    }
    //select tournaments with filter
    public function selectTournaments($id=null, $tournamentName=null, $minPrize=null, $maxPrize=null,
     $notoriety=null, $city=null, $dateTime=null, $idGame=null, $gameName=null, $dateLimit=null){
        $conds = "";
        $conds .= ($id != null) ? "T.IdTournoi = $id AND " : "";
        $conds .= ($tournamentName != null) ? "T.NomTournoi = '$tournamentName' AND " : "";
        $conds .= ($minPrize != null) ? "T.CashPrize >= $minPrize AND " : "";
        $conds .= ($maxPrize != null) ? "T.CashPrize <= $maxPrize AND " : "";
        $conds .= ($notoriety != null) ? "T.Lieu = '$city' AND " : "";
        $conds .= ($city != null) ? "T.Lieu = '$city' AND " : "";
        $conds .= ($dateTime != null) ? "T.DateHeureTournois = '$dateTime' AND " : "";
        $conds .= ($idGame != null) ? "J.IdJeu = $idGame AND " : "";
        $conds .= ($dateLimit != null) ? "J.DateLimiteInscription = '$dateLimit' AND " : "";
        $conds = substr($conds, 0, -4);
        $sql = "SELECT T.IdTournoi, T.NomTournoi, T.CashPrize, T.Notoriete, T.Lieu, T.DateHeureTournois,
         J.IdJeu, J.NomJeu, J.TypeJeu, J.TempsDeJeu, J.DateLimiteInscription
         FROM Tournois T, Contenir C, Game J $conds AND C.IdJeu = J.IdJeu AND C.IdTournoi = T.IdTournoi AND ".$conds;
        try{
            $mysql = parent::getConnection();
            $stm = $mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select tournament ".$e->getMessage(), 1);
        }
     }
     //select pool of a tournament
     public function selectTournamentPools($idTournament){
        $sql = "SELECT * FROM Poule P WHERE IdTournoi = $idTournament";
        try{
            $mysql = parent::getConnection();
            $stm = $mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select tournament pools ".$e->getMessage(), 1);
        }
     }
     //select match of a pool
     public function selectTournamentPoolMatches($idPool){
        $sql = "SELECT * FROM MatchJ M WHERE M.IdPoule = $idPool";
        try{
            $mysql = parent::getConnection();
            $stm = $mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select tournament pool matchs ".$e->getMessage(), 1);
        }
     }
     //select classement of a game 
    public function selectRanking($idGame)
    {
        $idGame = (int) $idGame;
        $sql = "SELECT * FROM Equipe E WHERE E.IdJeu = $idGame ORDER BY E.NbPointsE DESC";
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select ranking ".$e->getMessage(), 1);
        }
    }
    // Connect on the website
    function connectToWebsite(string $id, $role)
    {
        $mysql = $this->getConnection();
        $sql = "SELECT MDPCompte FROM '$role' WHERE NomCompte = '$id'";
        $result = $mysql->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }
    // Select all games in the database
    public function selectAllGames()
    {
        $mysql = $this->getConnection();
        $sql = "SELECT * FROM Game";
        return $mysql->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    //select participants of a tournament
    public function selectParticipants($idTournament){
        $sql = "SELECT * FROM Participer P WHERE P.IdTournoi = $idTournament";
        try{
            $mysql = parent::getConnection();
            $stm = $mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select tournament participents ".$e->getMessage(), 1);
        }
    }
    //select team and game 
    public function selectTeamGames($idTeam, $idGame=null){
        $sql = "SELECT * FROM Equipe E, Jeu J WHERE E.IdEquipe = $idTeam AND J.IdJeu = E.IdJeu";
        $sql .= ($idGame != null) ? " AND J.IdJeu = $idGame" : "";
        try{
            $mysql = parent::getConnection();
            $stm = $mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select team games ".$e->getMessage(), 1);
        }
    }
    //get game by id
    public function selectGameById($idGame){
        $sql = "SELECT * FROM Jeu WHERE IdJeu = $idGame";
        try{
            $mysql = parent::getConnection();
            $stm = $mysql->prepare($sql);
            $stm->execute();
            $data=$stm->fetchAll();
            $jeu = new Game($data[0]['IdJeu'],$data[0]['NomJeu'], $data[0]['TypeJeu'], $data[0]['TempsDeJeu'], $data[0]['DateLimiteInscription']);
            return $jeu;
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select tournament participents ".$e->getMessage(), 1);
        }
    }
    //select game for organization not create
    public static function selectGameTeamNotPlayed($idOrga)
    {
        $sql = "SELECT * FROM Jeu J WHERE J.IDjeu not in (SELECT E.IdJeu FROM Equipe E WHERE E.IDEcurie=$id)";
        try{
            $mysql = parent::getConnection();
            $stm = $mysql->prepare($sql);
            $stm->execute();
            $data=$stm->fetchAll();
            $jeux = array();
            foreach($data as $ligne){
                $jeux[] = new Game($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']);
            }
            return ($jeux);
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select tournament participents ".$e->getMessage(), 1);
        }
    }
    //select number participant of tournament
    public function selectnumberParticipant($idgame,$idT){
        $sql = "SELECT count(e.IdEquipe) as total FROM Participer p, Equipe e WHERE p.IdTournoi =$idT AND e.IdEquipe = p.IdEquipe AND e.IdJeu =$idgame";
        try{
            $mysql = parent::getConnection();
            $stm = $mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select tournament participents ".$e->getMessage(), 1);
        }
    }
    //select number pools for a game
    public function selectnumberPools($idgame,$idT){
        $sql = "SELECT count(*) as total FROM Poule WHERE IdTournoi =$idT AND IdJeu =$idgame";
        try{
            $mysql = parent::getConnection();
            $stm = $mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select tournament participents ".$e->getMessage(), 1);
        }
    }
    //select cashprize by id tournament
    public function selectCashPrizeById($idT){
        $sql = "SELECT T.CashPrize FROM Tournois T WHERE T.IdTournoi=$idT";
        try{
            $mysql = parent::getConnection();
            $stm = $mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select tournament participents ".$e->getMessage(), 1);
        }
    }
}