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

    }
    private function nbMatchsGagnes($equipe): int
    {
        return 0;
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
}

