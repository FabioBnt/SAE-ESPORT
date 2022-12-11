<?php declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__).'/modele/Tournois.php');
class DetailsTournoisTest extends \PHPUnit\Framework\TestCase {
    private $mysql;
    private $tournoi;
    protected function setUp(): void {
        $this->mysql = Database::getInstance();
        $this->tournoi = new Tournois();
        $this->tournoi->tousLesTournois();
        $this->tournoi = $this->tournoi->getTournoi(1);
    } 

    protected function tearDown(): void {
        $this->tournoi = null;
    }

    public function testParticipantsTournois() {
        $id = $this->tournoi->getIdTournoi();
        $totalParticipant = $this->mysql->select("count(*) as total", "Participer", "where IdTournoi = $id");
        $listeParticipant = $this->tournoi->lesEquipesParticipants();
        assertSame($totalParticipant[0]['total']-'0', count($listeParticipant));
    }
    public function testPouleTournois() {
        $id = $this->tournoi->getIdTournoi();
        $totalPoules = $this->mysql->select("count(*) as total", "Poule", "where IdTournoi = $id");
        $listePoules = $this->tournoi->getPoules();
        assertSame($totalPoules[0]['total']-'0', count($listePoules));
    }
    public function testMatchsTournoi() {
        $id = 3;
        $totalMatchs = $this->mysql->select("count(*) as total", "MatchJ", "where IdPoule = $id");
        $listeMatchs = $this->tournoi->getPoules()[$id]->getMatchs();
        assertSame($totalMatchs[0]['total']-'0', count($listeMatchs));
    }

}
?>