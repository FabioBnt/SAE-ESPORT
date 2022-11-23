<?php

class Classement
{
    private $jeu;
    private $equipes = array();
    public $classement = array();

    function __construct($jeu){
        $this->jeu = $jeu;
        $this->equipes = NULL;
        $this->classement = NULL;
    }
    
    public static function getInstance($jeu)
    {
        return NULL;
    }
    public function toString()
    {
        return NULL;
    }
}

?>