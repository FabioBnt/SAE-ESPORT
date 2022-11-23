<?php
include "Tournoi.php";
include "DataBase.php";
class Tournois
{
    private $tournois;
    function __construct(){
        $this->tournois = array();
    }
    public function tousLesTrournois()
    {
        $mysql = Database::getInstance();
        $pdo = $mysql->getPDO();
        $stmt = $pdo->prepare("select * from Tournois");
        $stmt->execute(); 
        $data = $stmt->fetchAll();
        $temp = array();
        foreach ($data as $ligne) {
            $tempsHeure = explode(" ", $ligne['DateHeureTournois']);
            $temp[] = new Tournoi($ligne['NomTournoi'], $ligne['CashPrize'], $ligne['Notoriete'], $ligne['Lieu'], $tempsHeure[1], $tempsHeure[0]);
        }
        $this->tournois = $temp;
    }
    public function tounoisDeJeu($jeu)
    {
        $this->tournois;
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
    public function afficherTournois()
    {
        echo "<table border='1'><br />";
        for ($ligne = 0; $ligne < count($this->tournois); $ligne ++) {
        echo "<tr>";
            echo "<td>", $this->tournois[$ligne], "</td>";
        echo "</tr>";
        }
        echo "</table>";
    }
}

$apple = new Tournois();
$apple->tousLesTrournois();
$apple->afficherTournois();

?>