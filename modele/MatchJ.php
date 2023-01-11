<?php
class MatchJ
{
    private $numero;
    private $date;
    private $heure;
    private $equipes = array();
    private $scores = array();
    function __construct($numero, $date, $heure){
        $this->numero = $numero;
        $this->date = $date;
        $this->heure = $heure;
    }
    public function addequipeScore($equipe, $score){
        $this->scores[$equipe->getId()] = $score;
        $this->equipes[$equipe->getId()] = $equipe;
    }
    public function toString()
    {
        return $this->heure;
    }
    public static function setScore(int $idPoule,int $idEquipe1,int $idEquipe2 ,int $score1,int $score2)
    {
        $muysql = Database::getInstance()->getPDO();
        $sql = "UPDATE Concourir SET Score = $score1 WHERE IdPoule = $idPoule AND IdEquipe = $idEquipe1";
        $muysql->query($sql);
        $sql = "UPDATE Concourir SET Score = $score2 WHERE IdPoule = $idPoule AND IdEquipe = $idEquipe2";
        $muysql->query($sql);
    }
    public function gagnant()
    {
    }

    /**
     * @return array
     */
    public function getEquipes(): array
    {
        return $this->equipes;
    }

    public function afficherEquipes(){
        echo "<tr>";
        foreach ($this->scores as $key => $ligneValue) {
            $equipe = $this->equipes[$key];
            echo "<td>", $equipe, "</td>";
            if($ligneValue == null){
                echo "<td>", 'TBD', "</td>"; 
            }else{
                echo "<td>", $ligneValue, "</td>"; 
            }
        }
        echo "</tr>";
    }
}