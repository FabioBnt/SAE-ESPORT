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
        if($cond==""){
            $this->misAJourListeTournois($mysql->select("*", "Tournois"));
        }else{
            $this->misAJourListeTournois($mysql->select("*", "Tournois", $cond));
        }
    }
    private function misAJourListeTournois($data){
        $this->tournois = array();
        foreach ($data as $ligne) {
            $tempsHeure = explode(" ", $ligne['DateHeureTournois']);
            $this->tournois[] = new Tournoi($ligne['NomTournoi'], $ligne['CashPrize'],
            $ligne['Notoriete'], $ligne['Lieu'], $tempsHeure[1], $tempsHeure[0]);
        }
    }
    public function tousLesTrournois()
    {
        $this->selectTournoi();
    }
    public function tournoisDeJeu(string $jeu)
    {
        //$this->selectTournoi("where Lower(NomJeu) like Lower('%$jeu%')");
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
    public function tournoiDe(/*string $nomJeu="",*/float $prixMin=-1,float $prixMax=-1,string $typeJeu="",string $notoriete="",string $lieu="",string $date=""){
        if(/*$nomJeu=="" &&*/ $prixMin==-1 && $prixMax==-1 && $notoriete=="" && $lieu=="" && $date==""){
            throw new Exception("Accun Argument passé");
        }
        $cond = "where ";
        /*if($nomJeu != ""){
            $cond.= " Lower(NomJeu) like Lower('%$nomJeu%') AND";
        }*/
        if($prixMax != -1){
            $cond.=" CashPrize <= $prixMax AND";
        }
        if($prixMin != -1){
            $cond.=" CashPrize >= $prixMin AND";
        }
        if($notoriete != ""){
            $cond.=" Notoriete = '$notoriete' AND";
        }
        if($lieu != ""){
            $cond.=" Lower(Lieu) like Lower('%$lieu%') AND";
        }
        if($lieu != ""){
            $cond.=" Date(DateHeureTournois) >= '$date' AND";
        }
        $cond = substr($cond, 0, -3);
        $this->selectTournoi($cond);


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
$apple->tournoiDe(-1,1000,"","","","");
$apple->afficherTournois();

?>