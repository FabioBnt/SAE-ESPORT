<?php declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include(dirname(__DIR__).'/modele/Administrateur.php');
class CreerEcurieTest extends \PHPUnit\Framework\TestCase {
    private $mysql;
    private $admin;
    protected function setUp(): void {
        $this->mysql = Database::getInstance();
        $this->admin = new Administrateur();
    } 

    protected function tearDown(): void {
        $this->tournois = null;
    }

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