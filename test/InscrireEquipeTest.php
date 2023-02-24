<?php 
declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/');
//créer un test inscrire equipe
class InscrireEquipeTest extends \PHPUnit\Framework\TestCase {
    private $mysql;
    private $equipe;
    private $tournois;
    //mettre en place
    protected function setUp(): void {
        $this->mysql = DAO::getInstance();
        $this->equipe = null;
        $this->tournois = new Tournois();
    } 
    //rénitialiser
    protected function tearDown(): void {
        $this->equipe = null;
    }
    public function testEquipeInscriptionValide() {
        Connection::getInstanceWithoutSession()->establishConnection('Cloud9FortniteCompte', 'PasswordCloud9Fortnite', Role::Equipe);
        $this->tournois->allTournaments();
        $this->equipe = Equipe::getEquipe(8);
        $tournoi = $this->tournois->getTournament(2);
        $idT = $tournoi->getIdTournament();
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $totalInscription = $this->mysql->select('count(*) as total', 'Participer', "where IdTournoi = $idT");
        $numInscriptions = $totalInscription[0]['total']-'0';
        $this->equipe->Inscrire($tournoi);
        $totalInscription = $this->mysql->select('count(*) as total', 'Participer', "where IdTournoi = $idT");
        assertSame($totalInscription[0]['total']-'0', $numInscriptions+ 1);
        $pdo->rollBack();
    }
    //test
    public function testEquipeDejaInscrit() {
        $this->expectException(Exception::class);
        Connection::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
        $this->tournois->allTournaments();
        $this->equipe = Equipe::getEquipe(8);
        $tournoi = $this->tournois->getTournaments()[0];
        $idT = $tournoi->getIdTournament();
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $this->equipe->Inscrire($tournoi);
        $this->equipe->Inscrire($tournoi);
        $pdo->rollBack();
    }
    //test
    public function testJeuIncompatible() {
        $this->expectException(Exception::class);
        Connection::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
        $this->tournois->allTournaments();
        $tournoi = $this->tournois->getTournaments()[1];
        $idT = $tournoi->getIdTournament();
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $this->equipe->Inscrire($tournoi);
        $pdo->rollBack();
    }
}
?>