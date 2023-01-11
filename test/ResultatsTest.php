<?php declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__).'/modele/Tournois.php');
include_once(dirname(__DIR__).'/modele/MatchJ.php');
class ResultatsTest extends \PHPUnit\Framework\TestCase {
    
    public function testSetScore() {
        Connexion::getInstanceSansSession()->seConnecter('Admin', '$iutinfo', Role::Administrateur);
        $mysql = Database::getInstance();
        $pdo = $mysql->getPDO();
        //$pdo->beginTransaction();
        MatchJ::setScore(4, 15, 16, 3, 5);
        $score = $mysql->select('Score', 'Concourir', 'WHERE IdPoule = 4 AND IdEquipe = 15');
        $score1 = $score[0]['Score']-'0';
        $score = $mysql->select('Score', 'Concourir', 'WHERE IdPoule = 4 AND IdEquipe = 16');
        $score2 = $score[0]['Score']-'0';
        assertSame($score1, 3);
        assertSame($score2, 5);
        $pdo->rollBack();
    }

}
?>