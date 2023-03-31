<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/Team.php');
require_once ('./dao/UserDAO.php');
//create a register team test
class RegisterTeamTest extends TestCase {
    private $equipe;
    private $tournois;
    //set up
    protected function setUp(): void {
        $this->equipe = null;
        $this->tournois = new Tournament();
    } 
    //tear down
    protected function tearDown(): void {
        $this->equipe = null;
    }
    //test
    public function testTeamRegisterValid() {
        $dao=new UserDAO();
        $dao->getConnection()->beginTransaction();
        Connection::getInstanceWithoutSession()->establishConnection('Cloud9FortniteCompte', 'PasswordCloud9Fortnite', Role::Team);
        $this->tournois->allTournaments();
        $this->equipe = Team::getTeam(8);
        $tournoi = $this->tournois->getTournament(2);
        $idT = $tournoi->getIdTournament();
        $totalInscription=$dao->selectNumberParticipant(2,$idT);
        $numInscriptions = $totalInscription[0]['total']-'0';
        $this->equipe->register($tournoi);
        $totalInscription=$dao->selectNumberParticipant(2,$idT);
        $dao->getConnection()->rollBack();
        assertSame($totalInscription[0]['total']-'0', $numInscriptions+ 1);
    }
    //test
    public function testTeamisRegistered() {
        $dao = new UserDAO();
        $dao->getConnection()->beginTransaction();
        $this->expectException(Exception::class);
        Connection::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
        $this->tournois->allTournaments();
        $this->equipe = Team::getTeam(8);
        $tournoi = $this->tournois->allTournaments()[0];
        $this->equipe->register($tournoi);
        $this->equipe->register($tournoi);
        $dao->getConnection()->rollBack();
    }
    //test
    public function testGameNotOk() {
        $dao = new UserDAO();
        $dao->getConnection()->beginTransaction();
        $this->expectException(Exception::class);
        Connection::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
        $this->tournois->allTournaments();
        $tournoi = $this->tournois->allTournaments()[1];
        $this->equipe->register($tournoi);
        $dao->getConnection()->rollBack();
    }
}
?>