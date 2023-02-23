<?php

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/Administrateur.php');
//créer un test de créer tournoi
class CreerTournoiTest extends \PHPUnit\Framework\TestCase {
    private $mysql;
    private $admin;
    //mettre en place
    protected function setUp(): void {
        $this->mysql = DAO::getInstance();
        $this->admin = new Administrateur();
    }
    //rénitialiser
    protected function tearDown(): void {
        $this->mysql = null;
        $this->admin = null;
    }
    //test
    public function testTournoiCreationValide(){
        Connexion::getInstanceSansSession()->seConnecter('admin','$iutinfo',Role::Administrateur);
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $this->admin->creerTournoi('test',100,'Local','Toulouse','15:00','25/05/2023',array(1));
        $total = $this->mysql->select('count(*) as total','Tournois','where NomTournoi = "test"');
        assertSame($total[0]['total']-'0',1);
        $pdo->rollBack();
    }
}
?>