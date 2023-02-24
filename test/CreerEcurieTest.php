<?php 
declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/Administrator.php');
//créer un test créer écurie
class CreerEcurieTest extends \PHPUnit\Framework\TestCase {
    private $mysql;
    private $admin;
    //mettre en place
    protected function setUp(): void {
        $this->mysql = DAO::getInstance();
        $this->admin = new Administrator();
    } 
    //rénitialiser
    protected function tearDown(): void {
        $this->mysql = null;
        $this->admin = null;
    }
    //test
    public function testEcurieAjouteDansBDD() {
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $totalEcurie = $this->mysql->select('count(*) as total', 'Ecurie');
        $numEcuries = $totalEcurie[0]['total']-'0';
        $this->admin->creerEcurie('test', 'test', 'test', 'Associative');
        $totalEcurie = $this->mysql->select('count(*) as total', 'Ecurie');
        assertSame($totalEcurie[0]['total']-'0', $numEcuries + 1);
        $pdo->rollBack();
    }
}
?>