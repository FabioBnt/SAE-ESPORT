<?php

class Inscriptions
{
    private $equipes = array();
    private $tournoi;
    private $inscriptions = array();
    private function __construct($tournoi){
        $this->equipes = NULL;
        $this->tournoi = $tournoi;
    }
    public function ajouterEquipe($equipe)
    {
    }
    public function getEquipes()
    {
        return $this->equipes;
    }
    public static function getInstance($tournoi)
    {
        return NULL;
    }
    public function toString()
    {
        return NULL;
    }
    public function getTournoi()
    {
        return $this->tournoi;
    }
}

?>