<?php 
declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/Tournois.php');
include_once(dirname(__DIR__) . '/model/MatchJ.php');
//créer un test de resultat
class ResultatsTest extends \PHPUnit\Framework\TestCase {
    //test
    public function testSetScore() {
        Connection::getInstanceWithoutSession()->establishConnection('Arbitre', '$iutinfo', Role::Administrator);
        $mysql = DAO::getInstance();
        $pdo = $mysql->getPDO();
        //$pdo->beginTransaction();
        $tournoi = new Tournois();
        // get tous les tournois
        $tournoi->allTournaments();
        // get le tournoi
        $t = $tournoi->getTournament(11);
        // get les Pools
        $Pools = $t->getPools();
        MatchJ::setScore($Pools[8],4, 15, 16, 3, 5);
        $score = $mysql->select('Score', 'Concourir', 'WHERE IdPoule = 4 AND IdEquipe = 15 and Numero = 4');
        $score1 = $score[0]['Score']-'0';
        $score = $mysql->select('Score', 'Concourir', 'WHERE IdPoule = 4 AND IdEquipe = 16 and Numero = 4');
        $score2 = $score[0]['Score']-'0';
        assertSame($score1, 3);
        assertSame($score2, 5);
        $pdo->rollBack();
    }
    // test mise a jour des points
    public function testMiseAJourDesPoins(){
        Connection::getInstanceWithoutSession()->establishConnection('Arbitre', '$iutinfo', Role::Administrator);
        $mysql = DAO::getInstance();
        $pdo = $mysql->getPDO();
        $pdo->beginTransaction();
        $tournoi = new Tournois();
        // get tous les tournois
        $tournoi->allTournaments();
        // get le tournoi
        $t = $tournoi->getTournament(11);
        // get les Pools
        $Pools = $t->getPools();
        // les equies de la Pool
        $equipes = $Pools[8][5]->TeamsOfPool();
        // get les points de l'equipe 15
        $classement = $Pools[8][5]->classementTeams();
        // get keys des equipes
        $pointsa = array();
        foreach($classement as $key => $value){
            $pointsa[] = $equipes[$key]->getPoints();
        }
        // get scores of match 15 vs 16
        $score = $mysql->select('Score', 'Concourir', 'WHERE IdPoule = 7 AND IdEquipe = 13');
        $score1 = $score[0]['Score']-'0';
        $score = $mysql->select('Score', 'Concourir', 'WHERE IdPoule = 7 AND IdEquipe = 17');
        $score2 = $score[0]['Score']-'0';
        MatchJ::setScore($Pools[8],7, 13, 17, $score1, $score2);
        $Pools = $t->getPools();
        // les equies de la Pool
        $equipes = $Pools[8][5]->TeamsOfPool();
        $points = array();
        foreach($classement as $key => $value){
            $points[] = $equipes[$key]->getPoints();
        }
        $pdo->rollBack();
        assertSame($points[0], $pointsa[0] + 95);
    }
}
?>