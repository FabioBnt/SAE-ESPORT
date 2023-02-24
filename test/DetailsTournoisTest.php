<?php 
declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/Tournois.php');
//créer un test details tournoi
class DetailsTournoisTest extends \PHPUnit\Framework\TestCase {
    private $mysql;
    private $tournoi;
    //mettre en place
    protected function setUp(): void {
        $this->mysql = DAO::getInstance();
        $this->tournoi = new Tournois();
        $this->tournoi->allTournaments();
        $this->tournoi = $this->tournoi->getTournament(1);
    } 
    //rénitialiser
    protected function tearDown(): void {
        $this->tournoi = null;
    }
    //test
    public function testParticipantsTournois() {
        $id = $this->tournoi->getIdTournament();
        $totalParticipant = $this->mysql->select("count(*) as total", "Participer", "where IdTournoi = $id");
        $listeParticipant = $this->tournoi->TeamsOfPoolParticipants();
        assertSame($totalParticipant[0]['total']-'0', count($listeParticipant));
    }
    //test
    public function testPoolTournois() {
        $id = $this->tournoi->getIdTournament();
        $totalPools = $this->mysql->select("count(*) as total", "Poule", "where IdTournoi = $id");
        $listePools = $this->tournoi->getPools();
        $sumPool = 0;
        foreach($listePools as $Pool){
            $sumPool += count($Pool);
        }
        assertSame($totalPools[0]['total']-'0', $sumPool);
    }
    //test
    public function testMatchsTournoi() {
        $id = 8;
        $this->tournoi = new Tournois();
        $this->tournoi->allTournaments();
        $this->tournoi = $this->tournoi->getTournament(11);
        $totalMatchs = $this->mysql->select("count(M.IdPoule) as total", "MatchJ M, Poule P", "where M.IdPoule = P.IdPoule AND P.IdTournoi = 11 AND P.IdJeu = $id AND P.IdPoule = 3");
        $listeMatchs = $this->tournoi->getPools()[$id][3]->getMatchs();
        assertSame($totalMatchs[0]['total']-'0', count($listeMatchs));
    }
}
?>