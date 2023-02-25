<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once(dirname(__DIR__) . '/model/Classement.php');
require_once ("./dao/TeamDAO.php");
//create a test classsement
class ClassementTest extends TestCase
{
    private $classement;
    //set up
    protected function setUp(): void
    {
        $this->classement = new Classement(new Game(8,"","","",""));
    }
    //tear down
    protected function tearDown(): void
    {
        $this->classement = null;
    }
    //test
    public function testClassement(): void
    {
        $dao = new TeamDAO();
        $totalClassement = $dao->countNumberTeamByGame(8);
        $this->classement->returnRanking(8);
        $listeClassement =  $this->classement->getClassement();
        $this->assertCount($totalClassement[0]['total'] - '0', $listeClassement);
    }
}
?>