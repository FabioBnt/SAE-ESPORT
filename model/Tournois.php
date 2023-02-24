<?php
include_once "Tournoi.php";
include_once "../dao/UserDAO.php";
include_once "../dao/TeamDAO.php";
include_once "Game.php";
//créer la liste de tournoi
class Tournois
{
    private $tournois;
    private $posMap;

    private $userDao;

    private $teamDao;
    //constructeur
    public function __construct(){
        $this->tournois = array();
        $this->userDao = new UserDAO();
        $this->teamDao = new TeamDAO();
    }
    //mettre a jour la liste des tournois
    private function updateListOfTournaments($data){
        $this->tournois = array();
        $this->posMap = array();
        $last = -1;
        $index = -1;
        foreach ($data as $ligne) {
            if($last != $ligne['IdTournoi']){ 
                $this->tournois[] = new Tournoi($ligne['IdTournoi'],$ligne['NomTournoi'], $ligne['CashPrize'],
                $ligne['Notoriete'], $ligne['Lieu'], $ligne['DateHeureTournois'], 
                array($ligne['IdJeu'], new Game($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription'])));
                $last = $ligne['IdTournoi'];
                $index+=1;
            }else{
                $this->tournois[$this->posMap[$ligne['IdTournoi']]]->ajouterJeu($ligne['IdJeu'],new Game($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']));
            }
            $this->posMap[$ligne['IdTournoi']] =  $index;
        }
    }
    //récupérer tous les tournois
    public function allTournaments()
    {
        $userDao = new UserDAO();
        $this->updateListOfTournaments($this->userDao->selectTournaments());
    }
    //récupérer les tournois par équipes
    public function tournamentsParticipatedByTeam($idEquipe)
    {
        $this->updateListOfTournaments($this->teamDao->selectTournamentsForTeam($idEquipe));
        return $this->tournois;
    }
    //récupérer les tournois par équipes pas joué
    public function tournamentsSuggestedByTeam($idEquipe, $idGame)
    {
        $this->updateListOfTournaments($this->teamDao->selectTournamentsForTeam($idEquipe, $idGame));
        return $this->tournois;
    }
    //selection de tournois (filtre)
    public function tournoiDe(string $gameName=null, string $tournamentName=null, float $minPrize=null, float $maxPrize=null, string $notoriety=null, string $city=null, string $dateTime=null)
    { 
        $this->updateListOfTournaments($this->userDao->selectTournaments(null,$tournamentName, $minPrize, $maxPrize, $notoriety, $city, $dateTime, $gameName, null));
    }
    //récupérer les tournois
    public function getTournois(){
        return $this->tournois;
    }
    //récupérer un tournoi par son id
    public function getTournoi($id){
        return $this->tournois[$this->posMap[$id]];
    }
}
?>