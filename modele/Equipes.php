<?php
include_once "Equipe.php";
include_once "Database.php";
include_once "Jeu.php";
class Equipes
{
    private $equipes;
    function __construct(){
        $this->equipes = array();
    }

    private function selectEquipe(string $cond=""){
        //
        $mysql = Database::getInstance();
        $data = $mysql->select("E.IdEquipe, E.NomE, E.NomCompte, E.MDPCompte, E.NbPointsE, E.IdJeu, E.IdEcurie",
         "Equipe E", "where E.IdEcurie ".$cond.' ORDER BY  IdJeu');
        $this->misAJourListeEquipes($data);
    }
    
    private function misAJourListeEquipes($data){
        //
        $this->equipes = array();
        $last = -1;
        $index = -1;
        foreach ($data as $ligne) {
            if($last != $ligne['IdEquipe']){ 
                $this->equipes[] = new Equipe($ligne['IdEquipe'],$ligne['NomE'], $ligne['NbPointsE'],$ligne['IdEcurie'],$ligne['IdJeu']);
                $last = $ligne['IdEquipe'];
                $index+=1;
            }
        }
    }
    public function tousLesEquipes()
    {
        $this->selectEquipe();
    }
    public function afficherEquipes()
    {
        foreach ($this->equipes as $ligneValue) {
        echo "<tr>";
            $equipe = $ligneValue->listeInfo();
            $index=0;
            foreach ($equipe as $colValue) {
                if($index==2){
                    $mysql = Database::getInstance();
                    $data = $mysql->selectL("J.NomJeu",
                    "Jeu J", "where J.IdJeu =".$colValue.'');
                    echo "<td>",$data['NomJeu'], "</td>";
                } else {
                    echo "<td>", $colValue, "</td>";
                }
                $index++;
            }
            echo "<td><a href='./DetailsEquipe.php?IDE=". $ligneValue->getId()."'>+</a></td>";
        echo "</tr>";
        }
    }

    public function getEquipes(){
        return $this->equipes;
    }

    public function getEquipe($id){
        return $this->equipes[$id];
    }
    
}
?>