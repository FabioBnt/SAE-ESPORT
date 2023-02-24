<?php

class UserDAO extends DAO{
    public function __construct(){
        parent::__construct();
    }

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

     //Retourner le classement du tournoi pour le jeu passé en paramètre
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

    /**
     * @param string $id : id of the user
     * @param $role : role of the user
     * @return array : array of the user's password
     */
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
}