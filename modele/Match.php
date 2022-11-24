<?php
class EMatch
{
    private $date;
    private $heure;
    private $scoreEquipe = array();
    function __construct($date, $heure, $equipe1, $equipe2){
        $this->date = $date;
        $this->heure = $heure;
        $this->scoreEquipe[$equipe1] = 0;
        $this->scoreEquipe[$equipe2] = 0;
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
}

?>