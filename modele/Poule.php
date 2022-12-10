<?php

class Poule
{
    private $id;
    private $numero;
    private $matchs = array();
    private $estFinale;
    private $jeu;

    function __construct($id, $numero, $estFinale, $jeu){
        $this->id = $id;
        $this->numero = $numero;
        $this->estFinale = $estFinale;
        $this->jeu = $jeu;
    }

    public function mellieurEquipe(){

    }
    private function nbMatchsGange($equipe){
        return 0;
    }
}

?>