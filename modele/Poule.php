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
    public function meilleureEquipe(){
        $equipes = $this->lesEquipes();
            $meilleur = null;
            $meilleurScore = -1;
            foreach ($equipes as $equipe) {
                $score = $this->nbMatchsGagnes($equipe->getId()); //nb match gagnés
                if($score > $meilleurScore){
                    $meilleur = $equipe;
                    $meilleurScore = $score;
                } else if($score == $meilleurScore){
                    $meilleur=$this->getDiffPoint ($meilleur,$equipe);
                }};
        return $meilleur;
    }

    public function meilleuresEquipes(){
        $equipes = $this->lesEquipes();
        $result = [];
        while (count($equipes)>1 ) {
            $meilleur = null;
            $meilleurScore = -1;
            foreach ($equipes as $equipe) {
                $score = $this->nbMatchsGagnes($equipe->getId()); //nb match gagnés
                if($score > $meilleurScore){
                    $meilleur = $equipe;
                    $meilleurScore = $score;
                } else if($score == $meilleurScore){
                    $meilleur=$this->getDiffPoint ($meilleur,$equipe);
                };
            }
            array_push($result, $meilleur);
            unset($equipes[array_search($meilleur,$equipes)]);
        }
        array_push($result, $equipes);
        return $result;
    }
    public function classementEquipes(){
        // add the number of match won by each team
        $equipes = $this->lesEquipes();
        $classement = array();
        foreach ($equipes as $equipe) {
            $classement[$equipe->getId()] = $this->nbMatchsGagnes($equipe->getId());
        }
        arsort($classement);
        return $classement;
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
    //prend en entrer 2 id d'équipe d'une même poule et ressort l'id de l'équipe ayant le plus de point
    public function getDiffPoint ($n1, $n2 ) {
        $e1=$n1->getId();
        $e2=$n2->getId();
        $mysql = Database::getInstance();
        $g1 = $mysql->select('SUM(Score)', '`Concourir`', 'where IdEquipe ='.$e1.' AND IdPoule = '.$this->id);
        $g2 = $mysql->select('SUM(Score)', '`Concourir`', 'where IdEquipe ='.$e2.' AND IdPoule = '.$this->id);
        //ID1 a gagné le plus de match ou égalité 
        if($g1 >= $g2){
            return $n1;
        //ID2 a gagné le plus de match
        } else {
            return $n2;
        }
    }
}

