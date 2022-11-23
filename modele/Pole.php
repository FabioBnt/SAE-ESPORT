<?php

class Poule
{
    private $numero;
    private $matchs = array();

    function __construct($numero, $matchs){
        $this->numero = $numero;
        $this->matchs = $matchs;
    }

    public function mellieurEquipe(){

    }
    private function nbMatchsGange($equipe){
        return 0;
    }
}

?>