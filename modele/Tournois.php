<?php
include_once "Tournoi.php";
include_once "Database.php";
include_once "Jeu.php";
class Tournois
{
    private $tournois;
    private $posMap;
    function __construct(){
        $this->tournois = array();
    }
    private function selectTournoi(string $cond=""){
        $mysql = Database::getInstance();
        $data = $mysql->select("T.IdTournoi, T.NomTournoi, T.CashPrize, T.Notoriete, T.Lieu, T.DateHeureTournois,
          J.IdJeu, J.NomJeu, J.TypeJeu, J.TempsDeJeu, J.DateLimiteInscription", "Tournois T, Contenir C, Jeu J", "where C.IdJeu = J.IdJeu
            AND C.IdTournoi = T.IdTournoi ".$cond.' ORDER BY  IdTournoi');
        $this->misAJourListeTournois($data);
    }
    
    private function misAJourListeTournois($data){
        $this->tournois = array();
        $this->posMap = array();
        $last = -1;
        $index = -1;
        foreach ($data as $ligne) {
            if($last != $ligne['IdTournoi']){ 
                $this->tournois[] = new Tournoi($ligne['IdTournoi'],$ligne['NomTournoi'], $ligne['CashPrize'],
                $ligne['Notoriete'], $ligne['Lieu'], $ligne['DateHeureTournois'], 
                array($ligne['IdJeu'], new Jeu($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription'])));
                $last = $ligne['IdTournoi'];
                $index+=1;
            }else{
                $this->tournois[$this->posMap[$ligne['IdTournoi']]]->ajouterJeu($ligne['IdJeu'],new Jeu($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']));
            }
            $this->posMap[$ligne['IdTournoi']] =  $index;
        }
    }
    public function tousLesTournois()
    {
        $this->selectTournoi();
    }
    public function tournoiDe(string $nomJeu="", string $nomTournois="", float $prixMin=0,float $prixMax=0,string $notoriete="",string $lieu="",string $date=""){
        if($nomJeu=="" && $nomTournois==="" && $prixMin===0 && $prixMax===0 && $notoriete==="" && $lieu==="" && $date===""){
            throw new Exception("Accun Argument passé");
        }
        $cond = "AND";
        if($nomJeu != ""){
            $cond.= " Lower(J.NomJeu) like Lower('%$nomJeu%') AND";
        }
        if($nomTournois != ""){
            $cond.=" T.NomTournoi <= $nomTournois AND";
        }
        if($prixMax != 0){
            $cond.=" T.CashPrize <= $prixMax AND";
        }
        if($prixMin != 0){
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
        $this->selectTournoi($cond);
    }
    public function afficherTournois()
    {
        foreach ($this->tournois as $ligneValue) {
        echo "<tr>";
            $tournoi = $ligneValue->listeInfo();
            foreach ($tournoi as $colValue) {
                echo "<td>", $colValue, "</td>";
            }
            echo "<td><a href='./DetailsTournoi.php?IDT=". $ligneValue->getIdTournoi()."'>+</a></td>";
        echo "</tr>";
        }
    }

    public function getTournois(){
        return $this->tournois;
    }

    public function getTournoi($id){
        return $this->tournois[$this->posMap[$id]];
    }
    
}
/*
include_once "Tournois.php";
$apple = new Tournois();
    $apple->tousLesTournois();
    $t = $apple->getTournoi(2);
    foreach ($t->getPoules() as $m){
        echo $m;
    }
    */
?>