<?php

include_once 'Connexion.php';


class Equipe
{
    private $nom;
    private $points;
    private $ecurie;
    private $jeu;
    public function __construct($nom, $points, $ecurie, $jeu){
        $this->nom = $nom;
        $this->points = $points;
        $this->ecurie = $ecurie;
        $this->jeu = $jeu;
    }

    public function inscrire($tournoi) {
        return 1;
    }
    public static function getEquipe($id){
        return new Equipe("test", 100, "test", "test");
    }
    public function toString() {
        return $this->nom;
    }


}
