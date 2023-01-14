<?php
include_once "MatchJ.php";
//créer une poule
class Poule
{
    private $id;
    private $numero;
    private $matchs = array();
    private $estFinale;
    private $jeu;
    //constructeur
    public function __construct($id, $numero, $estFinale, $jeu){
        $this->id = $id;
        $this->numero = $numero;
        $this->estFinale = $estFinale;
        $this->jeu = $jeu;
    }
    //ajouter un match a la poule
    public function addMatch($numero, $date, $heure, $equipes): void
    {
        $this->matchs[$numero] = new MatchJ($numero, $date, $heure);
        $mysql = Database::getInstance();
        $data = $mysql->select('*', 'Concourir', 'where IdPoule ='.$this->id.' AND Numero = '.$numero);
        foreach($data as $ligne){
            $this->matchs[$numero]->addEquipeScore($equipes[$ligne['IdEquipe']], $ligne['Score']);
        }
    }
    //récupéré la meilleur équipe de la poule
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
                }
            }
        return $meilleur;
    }
    //récupéré la liste des meilleures équipes Top4
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
                }
            }
            array_push($result, $meilleur);
            unset($equipes[array_search($meilleur,$equipes)]);
        }
        array_push($result, $equipes);
        return $result;
    }
    //récupéré le classement des équipes
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
    //récupéré le nb de match gagné d'une équipe sur la poule
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
    //récupéré le numéro de la poule
    public function getNumero(){
        return $this->numero;
    }
    //savoir si la poule est finale ou non
    public function estPouleFinale(){
        return $this->estFinale;
    }
    //récupéré la liste des matchs de la poule
    public function getMatchs(): array
    {
        return $this->matchs;
    }
    //récupéré l'id de la poule
    public function __toString()
    {
        return $this->id;
    }
    //récupéré les équipes de la poule
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

    // retounre l'id de la poule
    public function getId(){
        return $this->id;
    }
}
?>