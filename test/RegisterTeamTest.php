<?php 
declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/Team.php');
require_once ("./dao/UserDAO.php");
//create a register team test
class RegisterTeamTest extends \PHPUnit\Framework\TestCase {
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
        Connection::getInstanceWithoutSession()->establishConnection('Cloud9FortniteCompte', 'PasswordCloud9Fortnite', Role::Team);
        $this->tournois->allTournaments();
        $this->equipe = Team::getTeam(8);
        $tournoi = $this->tournois->getTournament(2);
        $idT = $tournoi->getIdTournament();
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $totalInscription=$dao->selectnumberParticipant(2,$idT);
        $numInscriptions = $totalInscription[0]['total']-'0';
        $this->equipe->register($tournoi);
        $totalInscription=$dao->selectnumberParticipant(2,$idT);
        assertSame($totalInscription[0]['total']-'0', $numInscriptions+ 1);
    }
    //test
    public function testTeamisRegistered() {
        $this->expectException(Exception::class);
        Connection::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
        $this->tournois->allTournaments();
        $this->equipe = Team::getTeam(8);
        $tournoi = $this->tournois->allTournaments()[0];
        $this->equipe->register($tournoi);
        $this->equipe->register($tournoi);
    }
    //test
    public function testGameNotOk() {
        $this->expectException(Exception::class);
        Connection::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
        $this->tournois->allTournaments();
        $tournoi = $this->tournois->allTournaments()[1];
        $this->equipe->register($tournoi);
    }
}
?>