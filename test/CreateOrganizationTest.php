<?php 
declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

require_once(dirname(__DIR__) . '/model/Administrator.php');
require_once ("../dao/AdminDAO.php");
//create a test organization
class CreateOrganizationTest extends \PHPUnit\Framework\TestCase {
    private $admin;
    //set up
    protected function setUp(): void {
        $this->admin = new Administrator();
    } 
    //tear down
    protected function tearDown(): void {
        $this->mysql = null;
        $this->admin = null;
    }
    //test
    public function testcreateOrganization() {
        $dao=new AdminDAO();
        $totalEcurie = $dao->countNumberOrganization();
        $numEcuries = $totalEcurie[0]['total']-'0';
        $this->admin->createOrganization('test', 'test', 'test', 'Associative');
        assertSame($totalEcurie[0]['total']-'0', $numEcuries + 1);
    }
}
?>