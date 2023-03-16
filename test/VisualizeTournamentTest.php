<?php
declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

require_once('../model/Tournament.php');
require_once("../dao/UserDAO.php");
//create a tournament test
class VisualizeTournamentTest extends \PHPUnit\Framework\TestCase
{
    private $tournois;
    //set up
    protected function setUp(): void
    {
        $this->tournois = new Tournament();
    }
    //tear down
    protected function tearDown(): void
    {
        $this->tournois = null;
    }
    //test
    public function testVisualizeallTournaments()
    {
        $dao = new UserDAO();
        $totalTournois = $dao->selectnumberTournament();
        $listeTournois = $this->tournois->allTournaments();
        assertSame($totalTournois[0]['total'] - '0', count($listeTournois));
    }
}
?>