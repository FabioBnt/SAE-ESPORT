<?php
class MatchJ
{
    private $date;
    private $heure;
    private $equipe1;
    private $equipe2;
    private $scores = array();
    function __construct($date, $heure, $equipe1, $equipe2){
        $this->date = $date;
        $this->heure = $heure;
        $this->scores[$equipe1] = 0;
        $this->scores[$equipe2] = 0;
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