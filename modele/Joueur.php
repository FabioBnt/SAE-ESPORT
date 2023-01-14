<?php
//créer un joueur
class Joueur
{
    private $pseudo;
    private $nationalite;
    //constructeur
    function __construct($pseudo, $nationalite){
        $this->pseudo = $pseudo;
        $this->nationalite = $nationalite;
    }
    //to string
    public function toString()
    {
        return $this->pseudo . $this->nationalite;
    }
}
?>