<?php declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include(dirname(__DIR__).'/modele/Equipe.php');
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
        $idT =  $this->tournois->getIdTournoi();
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $totalInscription = $this->mysql->select('count(*) as total', 'Inscriptions', "where IdTournois = $idT");
        $numInscriptions = $totalInscription[0]['total']-'0';
        $this->equipe->Inscrire($this->tournois->getTournois()[0]);
        $totalInscription = $this->mysql->select('count(*) as total', 'Inscriptions', "where IdTournois = $idT");
        assertSame($totalInscription[0]['total']-'0', $numInscriptions+ 1);
        $pdo->rollBack();
    }

}
?>