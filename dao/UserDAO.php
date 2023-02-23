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
         FROM Tournois T, Contenir C, Jeu J $conds AND C.IdJeu = J.IdJeu AND C.IdTournoi = T.IdTournoi AND ".$conds;

        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            return $result->execute();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select tournament ".$e->getMessage(), 1);
        }
     }


     public function selectTournamentsForTeam($idGame, $idEquipe=null){
        $sql = '';
        if($idEquipe != null){
                $sql = "select T.IdTournoi, T.NomTournoi, T.CashPrize, T.Notoriete, T.Lieu, T.DateHeureTournois,
                J.IdJeu, J.NomJeu, J.TypeJeu, J.TempsDeJeu, J.DateLimiteInscription FROM Tournois T, Contenir C, Jeu J where C.IdJeu = J.IdJeu
                AND C.IdTournoi = T.IdTournoi AND  J.IdJeu='".$idGame."' 
                AND T.IdTournoi not in (select DISTINCT T.IdTournoi from Tournois T, Contenir C, Jeu J , Equipe E, Participer P where C.IdJeu = J.IdJeu
                AND C.IdTournoi = T.IdTournoi AND T.IdTournoi=P.IdTournoi AND P.IdEquipe=E.IdEquipe AND E.IdJeu=J.IdJeu AND E.IdEquipe='".$idEquipe."')";
        }else{
            $sql = "select T.IdTournoi, T.NomTournoi, T.CashPrize, T.Notoriete, T.Lieu, T.DateHeureTournois,
            J.IdJeu, J.NomJeu, J.TypeJeu, J.TempsDeJeu, J.DateLimiteInscription FROM Tournois T, Contenir C, Jeu J , Equipe E, Participer P where C.IdJeu = J.IdJeu
            AND C.IdTournoi = T.IdTournoi AND T.IdTournoi=P.IdTournoi AND P.IdEquipe=E.IdEquipe AND E.IdJeu=J.IdJeu AND E.IdEquipe=".$idGame.' ORDER BY IdTournoi';
        }
        try{
            $mysql = parent::getConnection();
            $result = $mysql->prepare($sql);
            return $result->execute();
        }catch(PDOException $e){
            throw new Exception("Error Processing Request select tournament ".$e->getMessage(), 1);
        }
     }
    


}