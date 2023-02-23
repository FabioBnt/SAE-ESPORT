<?php 
declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/Equipe.php');
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
        Connexion::getInstanceSansSession()->seConnecter('Cloud9FortniteCompte', 'PasswordCloud9Fortnite', Role::Equipe);
        $this->tournois->tousLesTournois();
        $this->equipe = Equipe::getEquipe(8);
        $tournoi = $this->tournois->getTournoi(2);
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
    //test
    public function testEquipeDejaInscrit() {
        $this->expectException(Exception::class);
        Connexion::getInstanceSansSession()->seConnecter('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
        $this->tournois->tousLesTournois();
        $this->equipe = Equipe::getEquipe(8);
        $tournoi = $this->tournois->getTournois()[0];
        $idT = $tournoi->getIdTournoi();
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $this->equipe->Inscrire($tournoi);
        $this->equipe->Inscrire($tournoi);
        $pdo->rollBack();
    }
    //test
    public function testJeuIncompatible() {
        $this->expectException(Exception::class);
        Connexion::getInstanceSansSession()->seConnecter('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
        $this->tournois->tousLesTournois();
        $tournoi = $this->tournois->getTournois()[1];
        $idT = $tournoi->getIdTournoi();
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $this->equipe->Inscrire($tournoi);
        $pdo->rollBack();
    }
}
?>