<?php
include_once "MatchJ.php";
class Poule
{
    private $id;
    private $numero;
    private $matchs = array();
    private $estFinale;
    private $jeu;

    public function __construct($id, $numero, $estFinale, $jeu){
        $this->id = $id;
        $this->numero = $numero;
        $this->estFinale = $estFinale;
        $this->jeu = $jeu;
    }
    public function addMatch($numero, $date, $heure, $equipes): void
    {
        $this->matchs[$numero] = new MatchJ($numero, $date, $heure);
        $mysql = Database::getInstance();
        $data = $mysql->select('*', 'Concourir', 'where IdPoule ='.$this->id.' AND Numero = '.$numero);
        foreach($data as $ligne){
            $this->matchs[$numero]->addEquipeScore($equipes[$ligne['IdEquipe']], $ligne['Score']);
        }
    }
    public function meilleurEquipe(){
        $equipes = $this->lesEquipes();
        $meilleur = null;
        $meilleurScore = -1;
        foreach ($equipes as $equipe) {
            echo $equipe.'X';
            $score = $this->nbMatchsGagnes($equipe->getId()); //nb match gagnés
            echo $score.'||';
            if($score > $meilleurScore){
                $meilleur = $equipe;
                $meilleurScore = $score;
            } else if($score == $meilleurScore){
                
            };
        }
        return $meilleur;

    }
    public function nbMatchsGagnes($equipe): int
    {
        $nb = 0;
        foreach ($this->matchs as $match) {
            if($match->gagnant()->getId() == $equipe){
                $nb++;
            }
        }
        return $nb;
    }

    public function getNumero(){
        return $this->numero;
    }
    public function estPouleFinale(){
        return $this->estFinale;
    }
    public function getMatchs(): array
    {
        return $this->matchs;
    }
    public function __toString()
    {
        return $this->id;
    }

    public function lesEquipes(){
        $mysql = Database::getInstance();
        $data = $mysql->select('IdEquipe', '`Faire_partie`', 'where IdPoule ='.$this->id);
        $equipes = array();
        foreach($data as $ligne){
            $equipes[$ligne['IdEquipe']] = Equipe::getEquipe($ligne['IdEquipe']);
        }
        return $equipes;
        
    }
}

