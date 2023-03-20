<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/Tournament.php');
require_once ('./dao/UserDAO.php');
//create a tournament test
class VisualizeTournamentTest extends TestCase {
    private $tournois;
    //set up
    protected function setUp(): void {
        $this->tournois = new Tournament();
    } 
    //tear down
    protected function tearDown(): void {
        $this->tournois = null;
    }
    //test
    public function testVisualizeallTournaments() {
        $dao=new UserDAO();
        $totalTournois = $dao->selectNumberTournament();
        $listeTournois = $this->tournois->allTournaments();
        assertSame($totalTournois[0]['total']-'0', count($listeTournois));
    }
}
?>