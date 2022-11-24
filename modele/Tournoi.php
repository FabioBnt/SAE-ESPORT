<?php

class Tournoi
{
    private $nom;
    private $cashPrize;
    private $notoriete;
    private $lieu;
    private $heureDebut;
    private $date;
    private $poules = array();
    private $jeu = array();

    function __construct($nom, $cashPrize, $notoriete, $lieu, $heureDebut, $date){
        $this->nom = $nom;
        $this->cashPrize = $cashPrize;
        $this->notoriete = $notoriete;
        $this->lieu = $lieu;
        $this->heureDebut = $heureDebut;
        $this->date = $date;
        $this->poules = null;
        $this->jeu = null;
    }
    
    public function toString()
    {
        return $this->heureDebut;
    }
    private function genererLesPoules(){
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
    public function getNom(){
        return $this->nom;
    }
    public function getDate(){
        return $this->date;
    }
    public function __toString()
    {
        return $this->nom.' '.$this->cashPrize.'€ '.
        $this->notoriete.' '.
        $this->lieu.' '.
        $this->heureDebut.' '.
        $this->date;
    }

    public function getTable(){
        return array(
            'nom' => $this->nom,
            'cashPrize' => $this->cashPrize,
            'notoriete' => $this->notoriete,
            'lieu' => $this->lieu,
            'heureDebut' => $this->heureDebut,
            'date' => $this->date);
    }
}

?>