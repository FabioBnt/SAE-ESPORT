<?php 
declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/Tournament.php');
include_once(dirname(__DIR__) . '/model/MatchJ.php');
require_once ("./dao/ArbitratorDAO.php");
//create a result test
class ResultTest extends \PHPUnit\Framework\TestCase {
    //test
    public function testSetScore() {
        $dao=new ArbitratorDAO();
        Connection::getInstanceWithoutSession()->establishConnection('Arbitre', '$iutinfo', Role::Arbitre);
        $tournoi = new Tournament();
        // get tous les tournois
        $tournoi->allTournaments();
        // get le tournoi
        $t = $tournoi->getTournament(11);
        // get les Pools
        $Pools = $t->getPools();
        MatchJ::setScore($Pools[8],4, 15, 16, 3, 5);
        $score=$dao->selectScoreOfaTeam(4,15,4);
        $score1 = $score[0]['Score']-'0';
        $score=$dao->selectScoreOfaTeam(4,16,4);
        $score2 = $score[0]['Score']-'0';
        assertSame($score1, 3);
        assertSame($score2, 5);
    }
    // test
    public function updatePointsTeam(){
        $dao=new ArbitratorDAO();
        Connection::getInstanceWithoutSession()->establishConnection('Arbitre', '$iutinfo', Role::Arbitre);
        $tournoi = new Tournament();
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
        $score=$dao->selectScoreOfaTeam(4,13,1);
        $score1 = $score[0]['Score']-'0';
        $score=$dao->selectScoreOfaTeam(7,17,1);
        $score2 = $score[0]['Score']-'0';
        MatchJ::setScore($Pools[8],7, 13, 17, (int)$score1, (int)$score2);
        $Pools = $t->getPools();
        // team of Pool
        $equipes = $Pools[8][5]->TeamsOfPool();
        $points = array();
        foreach($classement as $key => $value){
            $points[] = $equipes[$key]->getPoints();
        }
        assertSame($points[0], $pointsa[0] + 95);
    }
}
?>