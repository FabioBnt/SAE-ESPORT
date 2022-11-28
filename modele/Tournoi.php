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
    private $jeux = array();

    function __construct($nom, $cashPrize, $notoriete, $lieu, $heureDebut, $date, array $jeux){
        $this->nom = $nom;
        $this->cashPrize = $cashPrize;
        $this->notoriete = $notoriete;
        $this->lieu = $lieu;
        $this->heureDebut = $heureDebut;
        $this->date = $date;
        $this->poules = null;
        $this->jeux = $jeux;
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

    public function listeInfo(){
        
        return array($this->nom,$this->cashPrize,$this->notoriete,$this->lieu,$this->heureDebut,$this->date, $this->nomsJeux());
    }
    private function nomsJeux(){
        $nomjeux ="";
        foreach($this->jeux as $jeu){
            $nomjeux.=$jeu->getNom().', ';
        }
        $nomjeux = substr($nomjeux, 0, -2);
        return $nomjeux;

    }
    public function ajouterJeu($jeu){
        $this->jeu[] = $jeu;
    }
    public function getIdTournoi(){
        
    }
}

?>