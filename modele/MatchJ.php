<?php
//créer un match
class MatchJ
{
    private $numero;
    private $date;
    private $heure;
    private $equipes = array();
    private $scores = array();
    //constructeur
    function __construct($numero, $date, $heure){
        $this->numero = $numero;
        $this->date = $date;
        $this->heure = $heure;
    }
    //ajouter le score de l'équipe
    public function addequipeScore($equipe, $score){
        $this->scores[$equipe->getId()] = $score;
        $this->equipes[$equipe->getId()] = $equipe;
    }
    //renvoie l'heure du match
    public function toString()
    {
        return $this->heure;
    }
    //initialise le score
    public static function setScore(int $idPoule,int $idEquipe1,int $idEquipe2 ,int $score1,int $score2)
    {
        $muysql = Database::getInstance()->getPDO();
        $sql = "UPDATE Concourir SET Score = $score1 WHERE IdPoule = $idPoule AND IdEquipe = $idEquipe1";
        $muysql->query($sql);
        $sql = "UPDATE Concourir SET Score = $score2 WHERE IdPoule = $idPoule AND IdEquipe = $idEquipe2";
        $muysql->query($sql);
        // check if all score are set in this poule and if it is poule finale
        $mysql = Database::getInstance();
        $data = $mysql->select("Count(*) as total", "Concourir c, Poule p", "WHERE p.IdPoule = c.IdPoule AND c.IdPoule = $idPoule AND c.Score IS NOT NULL AND p.EstPouleFinale = 1");
        $idT = self::getIdTournoi($idPoule);
        $idJ = self::getIdJeu($idPoule);
        if($data[0]['total'] == 12){
            //calculer points miseAJourDePoints dans tournois.php
            Tournoi::miseAJourDePoints($idT, $idJ);
        }
        // check if the poule finale wasnt set before
        // if it wasnt set before and all scores were set in all 4 poules then genererPouleFinale
        $data = $mysql->select("Count(*) as total", "Poule p", "WHERE p.IdTournoi = $idT AND p.IdJeu = $idJ AND p.EstPouleFinale = 1");
        if($data[0]['total']  ==  0){
            //TODO genererPouleFinale
            $data = $mysql->select("Count(*) as total", "Concourir c, Poule p", "WHERE  p.IdPoule = c.IdPoule AND p.IdTournoi = $idT AND p.IdJeu = $idJ AND c.Score IS NOT NULL");
            if($data[0]['total'] == 48){
                Tournoi::genererPouleFinale($idT, $idJ);
            }
        }
    }
    //récupéré un tournoi par son id de poule
    public static function getIdTournoi($idPoule) : int{
        $mysql = Database::getInstance();
        $row = $mysql->select("IdTournoi, IdJeu", "Poule", "WHERE IdPoule = $idPoule");
        return $row[0]['IdTournoi'];
    }
    //récupéré un jeu par son id de poule
    public static function getIdJeu($idPoule): int{
        $mysql = Database::getInstance();
        $row = $mysql->select("IdJeu", "Poule", "WHERE IdPoule = $idPoule");
        return $row[0]['IdJeu'];
    }
    // savoir si le score est initialisé ou non
    public function isScoreSet()
    {
        if($this->scores[0] == null || $this->scores[1] == null || $this->scores[0] == "" || $this->scores[1] == ""){
            return false;
        }else{
            return true;
        }
    }
    //savoir qui est le gagnant du match
    public function gagnant()
    {
        $t = array_keys($this->equipes);
        if($this->scores[$t[0]] > $this->scores[$t[1]]){
            return $this->equipes[$t[0]];
        }else if($this->scores[$t[0]] == $this->scores[$t[1]]){
            return new Equipe(0,"X",0,0,0);
        } else {
            return $this->equipes[$t[1]];
        }
    }
    /**
     * @return array
     */
    //récupéré les équipes
    public function getEquipes(): array
    {
        return $this->equipes;
    }
    //afficher les informations des équipes
    public function afficherEquipes(){
        echo "<tr>";
        foreach ($this->scores as $key => $ligneValue) {
            $equipe = $this->equipes[$key];
            echo "<td>", $equipe, "</td>";
            if($ligneValue == null){
                echo "<td>", 'TBD', "</td>"; 
            }else{
                echo "<td>", $ligneValue, "</td>"; 
            }
        }
        echo "</tr>";
    }
}
?>