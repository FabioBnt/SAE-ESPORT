<?php
include "Tournoi";
class Tournois
{
    private $tournois = array();
    function __construct(){
        $this->tournois = NULL;
    }
    public function tousLesTrournois()
    {
        $mysql = Database::getInstance();
        $pdo = $mysql->getPDO();
        $stmt = $pdo->prepare("select * from Tournois");
        $stmt->execute(); 
        $data = $stmt->fetchAll();
        $temp = array();
        foreach ($data as $row) {
            $tempsHeure = explode($row['DateHeureTournois'], " ");
            $temp[] = new Tournoi($row['NomTournoi'], $row['CashPrize'], $row['Notoriete'], $row['Lieu'], $tempsHeure[1], $tempsHeure[0]);
        }
        return $this->tournois;
    }
    public function tounoisDeJeu($jeu)
    {
        return $this->tournois;
    }
    public function tournoiDeNotoriete($notoriete)
    {
        return $this->tournois;
    }
    public function tournoiAuraLieu($lieu)
    {
        return $this->tournois;
    }
    public function tournoiAvecPrixSuperieurA($prix)
    {
        return $this->tournois;
    }
    public function tournoiCommenceLe($date)
    {
        return $this->tournois;
    }
    public function toString()
    {
        return NULL;
    }
}

?>