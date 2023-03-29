<?php
require_once('./dao/DAO.php');
require_once('./model/Role.php');
//create a user dao class
class UserDAO extends DAO{
    private PDO $mysql;
    //constructor
    public function __construct() {
        $this->mysql=parent::getInstance()->getConnection();
    }
    //select tournaments with filter
    public function selectTournaments(int $id=null,string $tournamentName=null,int $minPrize=null,int $maxPrize=null,
     string $notoriety=null,string $city=null,string $dateTime=null,string $gameName=null, int $idGame=null,string $dateLimit=null):array{
        $conds = '';
        $conds .= ($id != null) ? " AND T.IdTournoi = $id " : '';
        $conds .= ($tournamentName != null) ? " AND Lower(T.NomTournoi) like Lower('%$tournamentName%')" : '';
        $conds .= ($minPrize != null) ? " AND T.CashPrize >= $minPrize " : '';
        $conds .= ($maxPrize != null) ? " AND T.CashPrize <= $maxPrize " : '';
        $conds .= ($notoriety != null) ? " AND T.Notoriete = '$notoriety' " : '';
        $conds .= ($city != null) ? " AND Lower(T.Lieu) like Lower('%$city%')" : '';
        // transform date to mysql date format
        $dateTime = ($dateTime != null) ? date('Y-m-d', strtotime($dateTime)) : null;
        $conds .= ($dateTime != null) ? " AND T.DateHeureTournois like '%$dateTime%'" : '';
        $conds .= ($idGame != null) ? " AND J.IdJeu = $idGame" : '';
        $conds .= ($gameName != null) ? " AND Lower(J.NomJeu) like Lower('%$gameName%')" : '';
        $conds .= ($dateLimit != null) ? "AND J.DateLimiteInscription = $dateLimit" : '';
        $sql = 'SELECT DISTINCT T.IdTournoi, T.NomTournoi, T.CashPrize, T.Notoriete, T.Lieu, T.DateHeureTournois,
         J.IdJeu, J.NomJeu, J.TypeJeu, J.TempsDeJeu, J.DateLimiteInscription
         FROM Tournois T, Contenir C, Jeu J WHERE C.IdJeu = J.IdJeu AND C.IdTournoi = T.IdTournoi ' .$conds. ' ORDER BY 2';
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament ' .$e->getMessage(), 1);
        }
     }
     //select pool of a tournament
     public function selectTournamentPools(int $idTournament):array{
        $sql = "SELECT * FROM Poule P WHERE IdTournoi = $idTournament";
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament pools ' .$e->getMessage(), 1);
        }
     }
     //select match of a pool
     public function selectTournamentPoolMatches(int $idPool):array{
        $sql = "SELECT * FROM MatchJ M WHERE M.IdPoule = $idPool";
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament pool matchs ' .$e->getMessage(), 1);
        }
     }
     //select classement of a game 
    public function selectRanking(int $idGame):array
    {
        $idGame = (int) $idGame;
        $sql = "SELECT * FROM Equipe E WHERE E.IdJeu = $idGame ORDER BY E.NbPointsE DESC";
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select ranking ' .$e->getMessage(), 1);
        }
    }
    // Connect on the website
    public function connectToWebsite(string $id, string $role):array
    {
        if($role === Role::Organization){
            $role= 'Ecurie';
        } else if($role === Role::Team){
            $role= 'Equipe';
        }
        $sql = "SELECT MDPCompte FROM $role WHERE NomCompte='$id'";
        try{
            return $this->mysql->query($sql)->fetchAll();
        }catch(PDOException $e){
            throw new RuntimeException('Error Processing Request select ranking ' .$e->getMessage(), 1);
        }
    }
    // Select all games in the database
    public function selectAllGames():array
    {
        $sql = 'SELECT * FROM Jeu';
        try{
            $result = $this->mysql->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select ranking ' .$e->getMessage(), 1);
        }
    }
    //select participants of a tournament
    public function selectParticipants(int $idTournament):array{
        $sql = "SELECT * FROM Participer P WHERE P.IdTournoi = $idTournament";
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
    //select team and game 
    public function selectTeamGames(int $idTeam,int $idGame=null):array{
        $sql = "SELECT * FROM Equipe E, Jeu J WHERE E.IdEquipe = $idTeam AND J.IdJeu = E.IdJeu";
        $sql .= ($idGame != null) ? " AND J.IdJeu = $idGame" : '';
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select team games ' .$e->getMessage(), 1);
        }
    }
    //get game by id
    public function selectGameById(int $idGame):Game{
        $sql = "SELECT * FROM Jeu WHERE IdJeu = $idGame";
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            $data=$stm->fetchAll();
            $jeu = new Game($data[0]['IdJeu'],$data[0]['NomJeu'], $data[0]['TypeJeu'], $data[0]['TempsDeJeu'], $data[0]['DateLimiteInscription']);
            return $jeu;
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
    //select game for organization not create
    public function selectGameTeamNotPlayed(int $idOrga):array
    {
        $sql = "SELECT * FROM Jeu J WHERE J.Idjeu not in (SELECT E.IdJeu FROM Equipe E WHERE E.IDEcurie=$idOrga)";
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            $data=$stm->fetchAll();
            $jeux = array();
            foreach($data as $ligne){
                $jeux[] = new Game($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']);
            }
            return ($jeux);
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
    //select number participant of tournament
    public function selectNumberParticipant(int $idgame,int $idT):array{
        $sql = "SELECT count(e.IdEquipe) as total FROM Participer p, Equipe e WHERE p.IdTournoi =$idT AND e.IdEquipe = p.IdEquipe AND e.IdJeu =$idgame";
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
    //select number of tournament
    public function selectNumberTournament():array{
        $sql = 'SELECT count(IdTournoi) as total FROM Tournois';
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
    //select number match of a pool of tournament
    public function selectNumberMatchPool(int $idPool,int $idGame,int $idT):array{
        $sql = "SELECT count(M.IdPoule) as total FROM MatchJ M, Poule P WHERE M.IdPoule = P.IdPoule AND P.IdTournoi = $idT AND P.IdJeu = $idGame AND P.IdPoule = $idPool";
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
    //select number pools for a game
    public function selectNumberPools(int $idgame,int $idT):array{
        $sql = "SELECT count(*) as total FROM Poule WHERE IdTournoi =$idT AND IdJeu =$idgame";
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
    //select cashprize by id tournament
    public function selectCashPrizeById(int $idT):array{
        $sql = "SELECT T.CashPrize FROM Tournois T WHERE T.IdTournoi=$idT";
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
}
?>