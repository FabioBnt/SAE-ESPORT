<?php
//créer une inscription
class Inscriptions
{
    private $equipes = array();
    private $tournoi;
    private $inscriptions = array();
    //constructeur
    private function __construct($tournoi){
        $this->equipes = NULL;
        $this->tournoi = $tournoi;
    }
    //ajouter une équipe dans inscrit
    public function ajouterEquipe($equipe)
    {
    }
    //récupéré les équipes
    public function getEquipes()
    {
        return $this->equipes;
    }
    //récupéré l'instance d'un tournoi
    public static function getInstance($tournoi)
    {
        return NULL;
    }
    //to string
    public function toString()
    {
        return NULL;
    }
    //récupéré le tournoi
    public function getTournoi()
    {
        return $this->tournoi;
    }
}
?>