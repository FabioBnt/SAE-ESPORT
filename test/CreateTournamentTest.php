<?php

use function PHPUnit\Framework\assertSame;

require_once('../model/Administrator.php');
require_once ("../dao/AdminDAO.php");
//create a tournament test
class CreateTournamentTest extends \PHPUnit\Framework\TestCase {
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
    public function testcreateTournament(){
        $dao =new AdminDAO();
        Connection::getInstanceWithoutSession()->establishConnection('admin','$iutinfo',Role::Administrator);
        $this->admin->createTournament('test',100,'Local','Toulouse','15:00','25/05/2023',array(1));
        $total = $dao->VerifIfTournamentExist("test");
        assertSame($total[0]['total']-'0',1);
    }
}
?>