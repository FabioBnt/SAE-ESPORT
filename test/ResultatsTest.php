<?php 
declare(strict_types=1);
use function PHPUnit\Framework\assertSame;
include_once(dirname(__DIR__).'/modele/Tournois.php');
include_once(dirname(__DIR__).'/modele/MatchJ.php');
//créer un test de resultat
class ResultatsTest extends \PHPUnit\Framework\TestCase {
    //test
    public function testSetScore() {
        Connexion::getInstanceSansSession()->seConnecter('Arbitre', '$iutinfo', Role::Administrateur);
        $mysql = Database::getInstance();
        $pdo = $mysql->getPDO();
        //$pdo->beginTransaction();
        $tournoi = new Tournois();
        // get tous les tournois
        $tournoi->tousLesTournois();
        // get le tournoi
        $t = $tournoi->getTournoi(11);
        // get les poules
        $poules = $t->getPoules();
        MatchJ::setScore($poules[8],4, 15, 16, 3, 5);
        $score = $mysql->select('Score', 'Concourir', 'WHERE IdPoule = 4 AND IdEquipe = 15');
        $score1 = $score[0]['Score']-'0';
        $score = $mysql->select('Score', 'Concourir', 'WHERE IdPoule = 4 AND IdEquipe = 16');
        $score2 = $score[0]['Score']-'0';
        assertSame($score1, 3);
        assertSame($score2, 5);
        $pdo->rollBack();
    }
    // test mise a jour des points
    public function testMiseAJourDesPoins(){
        Connexion::getInstanceSansSession()->seConnecter('Arbitre', '$iutinfo', Role::Administrateur);
        $mysql = Database::getInstance();
        $pdo = $mysql->getPDO();
        $pdo->beginTransaction();
        $tournoi = new Tournois();
        // get tous les tournois
        $tournoi->tousLesTournois();
        // get le tournoi
        $t = $tournoi->getTournoi(11);
        // get les poules
        $poules = $t->getPoules();
        // les equies de la poule
        $equipes = $poules[8][5]->lesEquipes();
        // get les points de l'equipe 15
        $classement = $poules[8][5]->classementEquipes();
        // get keys des equipes
        $keys = array_keys($classement);
        $pointsa = $equipes[$keys[0]]->getPoints();
        // get scores of match 15 vs 16
        $score = $mysql->select('Score', 'Concourir', 'WHERE IdPoule = 7 AND IdEquipe = 13');
        $score1 = $score[0]['Score']-'0';
        $score = $mysql->select('Score', 'Concourir', 'WHERE IdPoule = 7 AND IdEquipe = 17');
        $score2 = $score[0]['Score']-'0';
        MatchJ::setScore($poules[8],7, 13, 17, $score1, $score2);
        $poules = $t->getPoules();
        // les equies de la poule
        $equipes = $poules[8][5]->lesEquipes();
        $points = $equipes[$keys[0]]->getPoints();
        $pdo->rollBack();
        //410?
        assertSame($points, 125);
    }
}
?>