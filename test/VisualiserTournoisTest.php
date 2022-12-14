<?php declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__).'/modele/Tournois.php');
class VisualiserTournoisTest extends \PHPUnit\Framework\TestCase {
    private $mysql;
    private $tournois;
    protected function setUp(): void {
        $this->mysql = Database::getInstance();
        $this->tournois = new Tournois();
    } 

    protected function tearDown(): void {
        $this->tournois = null;
    }

    public function testVisualiserTousLesTournois() {
        $totalTournois = $this->mysql->select("count(IdTournoi) as total", "Tournois");
        $this->tournois->tousLesTournois();
        $listeTournois =  $this->tournois->getTournois();
        assertSame($totalTournois[0]['total']-'0', count($listeTournois));
    }
    public function testTournoisFiltre() {
        $totalTournois = $this->mysql->select("count(*) as total", "Tournois", "where Notoriete = 'Local'
        AND Lower(Lieu) like Lower('toulouse') AND CashPrize > 0 AND CashPrize < 100000 AND Lower(NomTournoi) like Lower('%g%') AND Date(DateHeureTournois) >= '2023-06-20'");
        $this->tournois->tournoiDe('', 'g', 0, 100000, "Local", "toulouse", "2023-06-20");
        $listeTournois =  $this->tournois->getTournois();
        assertSame($totalTournois[0]['total']-'0', count($listeTournois));
    }
    public function testTournoisFiltreParJeu() {
        $totalTournois = $this->mysql->select("count(*) as total", "Tournois T, Contenir C, Jeu J", "where C.IdJeu = J.IdJeu
        AND C.IdTournoi = T.IdTournoi AND Lower(J.NomJeu) like Lower('%league%')");
        $this->tournois->tournoiDe('league');
        $listeTournois =  $this->tournois->getTournois();
        assertSame($totalTournois[0]['total']-'0', count($listeTournois));
    }

}
?>