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
        $data = $mysql->select("T.*, J.*", "Tournois T, Contenir C, Jeu J", "where C.IdJeu = J.IdJeu
            AND C.IdTournoi = T.IdTournoi ".$cond);
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
                $this->tournois[-1]->ajouterJeu($ligne['IdJeu'],new Jeu($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']));
            }
            $this->posMap[$ligne['IdTournoi']] =  $index;
        }
    }
    public function tousLesTournois()
    {
        $this->selectTournoi();
    }
    public function tournoiDe(string $nomJeu="", string $nomTournois="", float $prixMin=-1,float $prixMax=-1,string $notoriete="",string $lieu="",string $date=""){
        if($nomJeu=="" && $nomTournois="" && $prixMin==-1 && $prixMax==-1 && $notoriete=="" && $lieu=="" && $date==""){
            throw new Exception("Accun Argument passé");
        }
        $cond = "AND";
        if($nomJeu != ""){
            $cond.= " Lower(J.NomJeu) like Lower('%$nomJeu%') AND";
        }
        if($nomTournois != ""){
            $cond.=" T.NomTournoi <= $nomTournois AND";
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
        $this->selectTournoi($cond);
    }
    public function afficherTournois()
    {
        //echo "<table border='1'><br />";
        for ($ligne = 0; $ligne < count($this->tournois); $ligne ++) {
        echo "<tr>";
            $tournoi = $this->tournois[$ligne]->listeInfo();
            for($col = 0; $col < count($tournoi); $col++){
                echo "<td>", $tournoi[$col], "</td>"; 
            }
            echo "<td><a href='./DetailsTournoi.php?IDT=".$this->tournois[$ligne]->getIdTournoi()."'>Cliquez ici</a></td>";
        echo "</tr>";
        }
        echo "</table>";
    }

    public function getTournois(){
        return $this->tournois;
    }

    public function getTournoi($id){
        return $this->tournois[$this->posMap[$id]];
    }
    
}

    

?>