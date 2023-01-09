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
    public static function setScore($idPoule, $idEquipe1, $idEquipe2 , $score1, $score2)
    {
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