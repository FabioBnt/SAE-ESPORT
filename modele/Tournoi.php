<?php

class Tournoi
{
    private $id;
    private $nom;
    private $cashPrize;
    private $notoriete;
    private $lieu;
    private $heureDebut;
    private $date;
    private $dateLimiteInscription;
    private $poules = array();
    private $jeux = array();

    function __construct($id, $nom, $cashPrize, $notoriete, $lieu, $heureDateDebut, array $jeux){
        $this->id =$id;
        $this->nom = $nom;
        $this->cashPrize = $cashPrize;
        $this->notoriete = $notoriete;
        $this->lieu = $lieu;
        $this->heureDebut = date("h:m:s" ,strtotime($heureDateDebut));
        $this->date = date("d/m/y" ,strtotime($heureDateDebut));
        $this->poules = null;
        $this->jeux = $jeux;
        // on prend le numero de jours le plus grande entre les jeux de tournoi
        $maxJour = $jeux[0]->getlimiteInscription();
        foreach ($this->jeux as $jeu){
            $jours = $jeu->getlimiteInscription();
            if($maxJour > $jours){
                $maxJour = $jours;
            }
        }
        $datetime = date_create($heureDateDebut);
        $intervalJours = date_interval_create_from_date_string("$maxJour days");
        $this->dateLimiteInscription = date_format(date_sub($datetime,$intervalJours),"d/m/y");
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
    public function getNotoriete(){
        return $this->notoriete;
    }
    public function getLieu(){
        return $this->lieu;
    }
    public function getCashprize(){
        return $this->cashPrize;
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
        
        return array($this->nom,$this->cashPrize,$this->notoriete,$this->lieu,$this->heureDebut,$this->date,$this->dateLimiteInscription , $this->nomsJeux());
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
        return $this->id;
    }
    public function getDateLimiteInscription(){
        return $this->dateLimiteInscription;
    }
}

?>