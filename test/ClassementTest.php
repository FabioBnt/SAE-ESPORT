<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include_once(dirname(__DIR__) . '/model/Classement.php');
//créer un test classsement
class ClassementTest extends TestCase
{
    private $mysql;
    private $classement;
    //mettre en place
    protected function setUp(): void
    {
        $this->mysql = DAO::getInstance();
        $this->classement = new Classement(8);
        /*$this->classement->returnRanking(8);
        $this->classement = $this->classement->getClassement(8);*/
    }
    //rénitialiser
    protected function tearDown(): void
    {
        $this->classement = null;
    }
    //test
    public function testClassement(): void
    {
        $totalClassement = $this->mysql->select("count(*) as total", "Equipe", "where IdJeu = 8");
        $this->classement->returnRanking(8);
        $listeClassement =  $this->classement->getClassement(8);
        $this->assertCount($totalClassement[0]['total'] - '0', $listeClassement);
    }
}
?>