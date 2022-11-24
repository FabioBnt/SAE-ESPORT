<?php
include "Tournoi.php";
include "Database.php";
class Tournois
{
    private $tournois;
    function __construct(){
        $this->tournois = array();
    }
    private function selectTournoi(string $cond=""){
        $mysql = Database::getInstance();
        $data =null;
        if($cond==""){
            $data = $mysql->select("*", "Tournois");
        }else{
            $data = $mysql->select("*", "Tournois", $cond);
        }
        $this->misAJourListeTournois($data);
    }
    private function selectTournoiParJeu(string $cond=""){
        $mysql = Database::getInstance();
        $data = null;
        if($cond==""){
            $data = $mysql->select("*", "Tournois");
        }else{
            $data = $mysql->select("T.*", "Tournois T, Contenir C, Jeu J", $cond);
        }
        $this->misAJourListeTournois($data);
    }
    private function misAJourListeTournois($data){
        $this->tournois = array();
        foreach ($data as $ligne) {
            $tempsHeure = explode(" ", $ligne['DateHeureTournois']);
            $this->tournois[] = new Tournoi($ligne['NomTournoi'], $ligne['CashPrize'],
            $ligne['Notoriete'], $ligne['Lieu'], $tempsHeure[1], $tempsHeure[0]);
        }
    }
    public function tousLesTournois()
    {
        $this->selectTournoi();
    }
    private function tournoiDeJeuCond(string $jeu) : string
    {
        return ("C.IdJeu = J.IdJeu
        AND C.IdTournoi = T.IdTournoi AND Lower(J.NomJeu) like Lower('%$jeu%')");
    }
    public function tournoiDeNotoriete($notoriete)
    {
        $this->selectTournoi("where Notoriete = '$notoriete'");
    }
    public function tournoiAuraLieu($lieu)
    {
        $this->selectTournoi("where Lower(Lieu) like Lower('%$lieu%')");
    }
    public function tournoiAvecPrixSuperieurA($prix)
    {
        $this->selectTournoi("where CashPrize > $prix");
    }
    public function tournoiCommenceApres($date)
    {
        $this->selectTournoi("where Date(DateHeureTournois) >= '$date'");
    }
    public function tournoiDe(string $nomJeu="",float $prixMin=-1,float $prixMax=-1,string $typeJeu="",string $notoriete="",string $lieu="",string $date=""){
        if($nomJeu=="" && $prixMin==-1 && $prixMax==-1 && $notoriete=="" && $lieu=="" && $date==""){
            throw new Exception("Accun Argument passé");
        }
        $cond = "where ";
        if($nomJeu != ""){
            $cond.= ' '.$this->tournoiDeJeuCond($nomJeu).' AND';
        }
        if($prixMax != -1){
            $cond.=" T.CashPrize <= $prixMax AND";
        }
        if($prixMin != -1){
            $cond.=" T.CashPrize >= $prixMin AND";
        }
        if($notoriete != ""){
            $cond.=" T.Notoriete = '$notoriete' AND";
        }
        if($lieu != ""){
            $cond.=" Lower(T.Lieu) like Lower('%$lieu%') AND";
        }
        if($lieu != ""){
            $cond.=" Date(T.DateHeureTournois) >= '$date' AND";
        }
        $cond = substr($cond, 0, -3);
        $this->selectTournoiParJeu($cond);


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

?>