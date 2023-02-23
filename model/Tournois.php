<?php
include_once "Tournoi.php";
include_once "DAO.php";
include_once "Jeu.php";
//créer la liste de tournoi
class Tournois
{
    private $tournois;
    private $posMap;
    //constructeur
    public function __construct(){
        $this->tournois = array();
    }
    //mettre a jour la liste des tournois
    private function misAJourListeTournois($data){
        $this->tournois = array();
        $this->posMap = array();
        $last = -1;
        $index = -1;
        foreach ($data as $ligne) {
            if($last != $ligne['IdTournoi']){ 
                $this->tournois[] = new Tournoi($ligne['IdTournoi'],$ligne['NomTournoi'], $ligne['CashPrize'],
                $ligne['Notoriete'], $ligne['Lieu'], $ligne['DateHeureTournois'], 
                array($ligne['IdJeu'], new Jeu($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription'])));
                $last = $ligne['IdTournoi'];
                $index+=1;
            }else{
                $this->tournois[$this->posMap[$ligne['IdTournoi']]]->ajouterJeu($ligne['IdJeu'],new Jeu($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']));
            }
            $this->posMap[$ligne['IdTournoi']] =  $index;
        }
    }
    //récupérer tous les tournois
    public function tousLesTournois()
    {
        $user = new UserDAO();
        $this->misAJourListeTournois($user->selectTournaments());
    }
    //récupérer les tournois par équipes
    public function TournoisEquipe($idGame)
    {
        $user = new UserDAO();
        $this->misAJourListeTournois($user->selectTournamentsForTeam($idGame));
        return $this->tournois;
    }
    //récupérer les tournois par équipes pas joué
    public function TournoisEquipeNJ($idGame,$idEquipe)
    {
        $user = new UserDAO();
        $this->misAJourListeTournois($user->selectTournamentsForTeam($idGame,$idEquipe));
        return $this->tournois;
    }
    //selection de tournois (filtre)
    public function tournoiDe(string $gameName=null, string $tournamentName=null, float $minPrize=null, float $maxPrize=null, string $notoriety=null, string $city=null, string $dateTime=null)
    {
        $user = new UserDAO(); 
        $this->misAJourListeTournois($user->selectTournaments(null,$tournamentName, $minPrize, $maxPrize, $notoriety, $city, $dateTime, $gameName, null));
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