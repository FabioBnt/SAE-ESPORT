<?php

class Tournois
{
    private $tournois = array();
    function __construct(){
        $this->tournois = NULL;
    }
    public function tousLesTrournois()
    {
        return $this->tournois;
    }
    public function tounoisDeJeu($jeu)
    {
        return $this->tournois;
    }
    public function tournoiDeNotoriete($notoriete)
    {
        return $this->tournois;
    }
    public function tournoiAuraLieu($lieu)
    {
        return $this->tournois;
    }
    public function tournoiAvecPrixSuperieurA($prix)
    {
        return $this->tournois;
    }
    public function tournoiCommenceLe($date)
    {
        return $this->tournois;
    }
    public function toString()
    {
        return NULL;
    }
}

?>