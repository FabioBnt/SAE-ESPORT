<?php

include 'Connexion.php';


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
    }
    public static function getEquipe($id){
    }
    public function toString() {
        return $this->nom;
    }


}
