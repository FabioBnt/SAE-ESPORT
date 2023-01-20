<?php
include_once "Equipe.php";
include_once "Database.php";
include_once "Jeu.php";
//créer la liste équipes
class Equipes
{
    private $equipes;
    //constructeur
    function __construct(){
        $this->equipes = array();
    }
    // select mysql d'une liste d'équipe
    public function selectEquipe(string $cond=""){
        //
        $mysql = Database::getInstance();
        $data = $mysql->select("E.IdEquipe, E.NomE, E.NomCompte, E.MDPCompte, E.NbPointsE, E.IdJeu, E.IdEcurie",
         "Equipe E", "where E.IdEcurie ".$cond.' ORDER BY  IdJeu');
        $this->misAJourListeEquipes($data);
    }
    //mettre a jour la liste
    private function misAJourListeEquipes($data){
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
    //récupéré toutes les équipes bdd
    public function tousLesEquipes()
    {
        $this->selectEquipe();
    }
    //afficher les informations des équipes
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
            echo "<td><a href='./DetailsEquipe.php?IDE=". $ligneValue->getId()."'><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>";
        echo "</tr>";
        }
    }
    //récupéré les équipes de la liste
    public function getEquipes(){
        return $this->equipes;
    }
    //récupéré une équipe par son id
    public function getEquipe($id){
        $mysql = Database::getInstance();
        $data = $mysql->select("*",
         "Equipe E", "where E.IdEquipe= ".$id."");
         return $data;
    } 
    //afficher les informations des équipes d'une écurie
    public function afficherEquipesE()
    {
        foreach ($this->equipes as $ligneValue) {
            echo "<tr>";
            echo "<td>",$ligneValue->getNom(), "</td>";
            $mysql = Database::getInstance();
            $data = $mysql->selectL("J.NomJeu",
            "Jeu J", "where J.IdJeu =".$ligneValue->getJeuS().'');
            echo "<td>",$data['NomJeu'], "</td>";
            echo "<td><a href='./DetailsEquipe.php?IDE=". $ligneValue->getId()."'><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>";
            echo "</tr>";
        }
    }
}
?>