<?php declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__).'/modele/Equipe.php');
class InscrireEquipeTest extends \PHPUnit\Framework\TestCase {
    private $mysql;
    private $equipe;
    private $tournois;
    protected function setUp(): void {
        $this->mysql = Database::getInstance();
        $this->equipe = Equipe::getEquipe(1);
        $this->tournois = new Tournois();
    } 

    protected function tearDown(): void {
        $this->equipe = null;
    }

    public function testEquipeIscriptionValide() {
        $this->tournois->tousLesTournois();
        $tournoi =  $this->tournois->getTournois()[0];
        $idT = $tournoi->getIdTournoi();
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $totalInscription = $this->mysql->select('count(*) as total', 'Participer', "where IdTournoi = $idT");
        $numInscriptions = $totalInscription[0]['total']-'0';
        $this->equipe->Inscrire($tournoi);
        $totalInscription = $this->mysql->select('count(*) as total', 'Participer', "where IdTournoi = $idT");
        assertSame($totalInscription[0]['total']-'0', $numInscriptions+ 1);
        $pdo->rollBack();
    }

}
?>