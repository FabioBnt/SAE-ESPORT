<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

require_once('./model/Tournament.php');
require_once ('./model/Connection.php');
require_once ('./model/Game.php');
require_once ('./model/Team.php');
//create a details tournament test
class DetailsTournamentTest extends TestCase {
    private $tournoi;
    //set up
    protected function setUp(): void {
        $this->tournoi = new Tournament();
        $this->tournoi->allTournaments();
        $this->tournoi = $this->tournoi->getTournament(1);
    } 
    //tear down
    protected function tearDown(): void {
        $this->tournoi = null;
    }
    //test
    public function testParticipantsTournament() {
        $id = $this->tournoi->getIdTournament();
        $dao= new UserDAO();
        $totalParticipant = $dao->selectnumberParticipant(1,$id);
        $listeParticipant = $this->tournoi->TeamsOfPoolParticipants();
        assertSame($totalParticipant[0]['total']-'0', count($listeParticipant));
    }
    //test
    public function testPoolTournament() {
        $id = $this->tournoi->getIdTournament();
        $dao= new UserDAO();
        $totalPools = $dao->selectnumberPools(1,$id);
        $listePools = $this->tournoi->getPools();
        $sumPool = 0;
        foreach($listePools as $Pool){
            $sumPool += count($Pool);
        }
        assertSame($totalPools[0]['total']-'0', $sumPool);
    }
    //test
    public function testMatchsTournament() {
        $idGame = 8;
        $this->tournoi = new Tournament();
        $dao=new UserDAO();
        $this->tournoi->allTournaments();
        $this->tournoi = $this->tournoi->getTournament(11);
        $totalMatchs = $dao->selectnumberMatchPool(3,$idGame,$this->tournoi->getIdTournament());
        $listeMatchs = $this->tournoi->getPools()[$idGame][3]->getMatchs();
        assertSame($totalMatchs[0]['total']-'0', count($listeMatchs));
    }
}
?>