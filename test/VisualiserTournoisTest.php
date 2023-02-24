<?php 
declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/Tournois.php');
//créer un test de visualiser tournoi
class VisualiserTournoisTest extends \PHPUnit\Framework\TestCase {
    private $mysql;
    private $tournois;
    //mettre en place
    protected function setUp(): void {
        $this->mysql = DAO::getInstance();
        $this->tournois = new Tournois();
    } 
    //rénitialiser
    protected function tearDown(): void {
        $this->tournois = null;
    }
    //test
    public function testVisualiserallTournaments() {
        $totalTournois = $this->mysql->select("count(IdTournoi) as total", "Tournois");
        $this->tournois->allTournaments();
        $listeTournois =  $this->tournois->getTournois();
        assertSame($totalTournois[0]['total']-'0', count($listeTournois));
    }
    //test
    public function testTournoisFiltre() {
        $totalTournois = $this->mysql->select("count(*) as total", "Tournois", "where Notoriete = 'Local'
        AND Lower(Lieu) like Lower('toulouse') AND CashPrize > 1 AND CashPrize < 100000 AND Lower(NomTournoi) like Lower('%g%') AND Date(DateHeureTournois) = '2023-06-20'");
        $this->tournois->tournoiDe('', 'g', 1, 100000, "Local", "toulouse", "2023-06-20");
        $listeTournois =  $this->tournois->getTournois();
        assertSame($totalTournois[0]['total']-'0', count($listeTournois));
    }
    //test
    public function testTournoisFiltreParJeu(): void
    {
        $totalTournois = $this->mysql->select("count(*) as total", "Tournois T, Contenir C, Jeu J", "where C.IdJeu = J.IdJeu
        AND C.IdTournoi = T.IdTournoi AND Lower(J.NomJeu) like Lower('%league%')");
        $this->tournois->tournoiDe('league');
        $listeTournois =  $this->tournois->getTournois();
        assertSame($totalTournois[0]['total']-'0', count($listeTournois));
    }
}
?>