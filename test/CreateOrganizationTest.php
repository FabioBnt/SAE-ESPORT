<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

require_once(dirname(__DIR__) . '/model/Administrator.php');
//create a test organization
class CreateOrganizationTest extends TestCase {
    private $admin;
    //set up
    protected function setUp(): void {
        $this->admin = new Administrator();
    }
    //tear down
    protected function tearDown(): void {
        $this->admin = null;
    }
    //test

    /**
     * @throws Exception
     */
    public function testcreateOrganization(): void
    {
        $dao = new AdminDAO();
        $dao->getConnection()->beginTransaction();
        $totalEcurieBefore = $dao->countNumberOrganization();
        $numEcuriesBefore = $totalEcurieBefore[0]['total']-'0';
        $this->admin->createOrganization('test', 'test', 'test', 'Associative');
        $totalEcurieAfter = $dao->countNumberOrganization();
        $dao->getConnection()->rollBack();
        assertSame($totalEcurieAfter[0]['total']-'0', $numEcuriesBefore + 1);
    }
}
?>