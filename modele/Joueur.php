<?php

class Joueur
{
    private $pseudo;
    private $nationalite;
    function __construct($pseudo, $nationalite){
        $this->pseudo = $pseudo;
        $this->nationalite = $nationalite;
    }
    public function toString()
    {
        return $this->pseudo . $this->nationalite;
    }
}

?>