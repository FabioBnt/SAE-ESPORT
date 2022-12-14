<?php
class MatchJ
{
    private $numero;
    private $date;
    private $heure;
    private array $equipes = array();
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
    public function setScore($scores)
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
        foreach ($this->equipes as $key => $ligneValue) {
            $ou = Equipe::getEquipe($key);
            echo "<tr>";
                $equipe = $ou->listeInfo();
            foreach ($equipe as $colValue) {
                echo "<td>", $colValue, "</td>";
            }
            echo "</tr>";
        }
    }
}