<?php

class Tournoi
{
    private $nom;
    private $prix;
    private $notoriete;
    private $lieu;
    private $heureDebut;
    private $date;
    private $poules = array();
    private $jeu = array();

    function __construct($nom, $prix, $notoriete, $lieu, $heureDebut, $date){
        $this->nom = $nom;
        $this->prix = $prix;
        $this->notoriete = $notoriete;
        $this->lieu = $lieu;
        $this->heureDebut = $heureDebut;
        $this->date = $date;
        $this->poules = NULL;
        $this->jeu = NULL;
    }
    
    public function toString()
    {
        return $this->heureDebut;
    }
    private function genererLesPoules()
    {
    }
    public function genererPouleFinale()
    {
    }
    private function meilleursEquipes()
    {
        return NULL;
    }
    private function miseAJourDePoints()
    {
    }
}

?>