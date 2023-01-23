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
    //ajouter le score de l'équipe et l'équipe
    public function addequipeScore($equipe, $score){
        $this->scores[$equipe->getId()] = $score;
        $this->equipes[$equipe->getId()] = $equipe;
    }
    //ajouter le score
    public function setEquipeScore($equipeId, $score){
        $this->scores[$equipeId] = $score;
    }
    //renvoyer l'heure du match
    public function toString()
    {
        return $this->heure;
    }
    //initialiser le score
    public static function setScore($poules, int $idPoule,int $idEquipe1,int $idEquipe2 ,int $score1,int $score2)
    {
        $mysql = Database::getInstance();
        $data = $mysql->select("Numero", "Concourir", "WHERE IdPoule = $idPoule AND IdEquipe = $idEquipe1 AND Numero in
         (SELECT Numero FROM Concourir WHERE IdPoule = $idPoule AND IdEquipe = $idEquipe2)");
        $numero = $data[0]['Numero'];
        $poules[$idPoule]->setScoreMatch($numero, $idEquipe1, $idEquipe2, $score1, $score2);
        $muysql = $mysql->getPDO();
        $sql = "UPDATE Concourir SET Score = $score1 WHERE IdPoule = $idPoule AND IdEquipe = $idEquipe1 AND Numero = $numero";
        $muysql->query($sql);
        $sql = "UPDATE Concourir SET Score = $score2 WHERE IdPoule = $idPoule AND IdEquipe = $idEquipe2 AND Numero = $numero";
        $muysql->query($sql);

        //get id tournoi et id jeu
        $idT = MatchJ::getIdTournoi($idPoule);
        $idJ = MatchJ::getIdJeu($idPoule);

        $pouleFinaleExiste = false;
        $cmpt = 0;
        //si c'est la poule finale on vérifie si tous les scores sont initialisés
       foreach($poules as $poule){
           if($poule->estPouleFinale()){
                $pouleFinaleExiste = true;
                if($poule->checkIfAllScoreSet()){
                    Tournoi::miseAJourDePoints($idT, $idJ);
                }
           }
           // sinon on vérifie si tous les scores sont initialisés et on ajoute 1 a cmpt
           else if($poule->checkIfAllScoreSet()){
                $cmpt++;
           }
        }
        if(!$pouleFinaleExiste && $cmpt == 4){
           
            Tournoi::genererPouleFinale($idT, $idJ);
        }
    }
    //récupérer un tournoi par son id de poule
    public static function getIdTournoi($idPoule) : int{
        $mysql = Database::getInstance();
        $row = $mysql->select("IdTournoi", "Poule", "WHERE IdPoule = $idPoule");
        return $row[0]['IdTournoi'];
    }
    //récupérer un jeu par son id de poule
    public static function getIdJeu($idPoule): int{
        $mysql = Database::getInstance();
        $row = $mysql->select("IdJeu", "Poule", "WHERE IdPoule = $idPoule");
        return $row[0]['IdJeu'];
    }
    // savoir si le score est initialisé ou non
    public function isScoreSet()
    {
        foreach($this->scores as $score){
            if($score == null){
                return false;
            }
        }
        return true;
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
    //récupérer les équipes
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