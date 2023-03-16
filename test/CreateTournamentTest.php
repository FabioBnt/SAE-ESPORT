<?php

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

require_once(dirname(__DIR__) . '/model/Administrator.php');
require_once('./model/Connection.php');
//create a tournament test
class CreateTournamentTest extends TestCase {
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

    /**
     * @throws Exception
     */
    public function testcreateTournament(): void
    {
        $dao =new AdminDAO();
        Connection::getInstanceWithoutSession()->establishConnection('admin','$iutinfo',Role::Administrator);
        $this->admin->createTournament('test',100,'Local','Toulouse','15:00','25/05/2023',array(1));
        $total = $dao->VerifIfTournamentExist('test');
        assertTrue($total);
    }
}
?>