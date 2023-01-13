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
        // check if all score are set in this poule and if it is poule finale
        /*$sql = "SELECT Count(*) as total FROM Concourir WHERE IdPoule = $idPoule AND Score IS NOT NULL AND EstPouleFinale = 1";
        $result = $muysql->query($sql);
        $row = $result->fetch();
        if($row['total'] == 6){
            //TODO calculer points miseAJourDePoints dans tournois.php
            
        }*/
        // TODO check if the poule finale wasnt set before
        // if it wasnt set before and all scores were set in all 4 poules then genererPouleFinale

    }
    public function gagnant()
    {
        $t = array_keys($this->equipes);
        if($this->scores[$t[0]] > $this->scores[$t[1]]){
            return $this->equipes[$t[0]];
        }else if($this->scores[$t[0]] == $this->scores[$t[1]]){
            return new Equipe(0,"X",0,0,0);
        } else {
            return $this->equipes[$t[1]];
        };
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