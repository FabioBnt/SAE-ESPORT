<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

require_once(dirname(__DIR__) . '/model/Tournament.php');
require_once(dirname(__DIR__) . '/model/MatchJ.php');
require_once(dirname(__DIR__) . '/model/Pool.php');
require_once(dirname(__DIR__) . '/model/Administrator.php');
require_once ('./dao/AdminDAO.php');
require_once ('./dao/TeamDAO.php');
require_once ('./model/Team.php');
require_once ('./dao/UserDAO.php');
require_once ('./model/Connection.php');
require_once ('./model/Game.php');
//créer un test générer Pool
class GeneratePoolsTest extends TestCase {
    private Tournament $tournoi;
    private Administrator $admin;
    private Team $equipe;
    //mettre en place
    protected function setUp(): void {
        $this->admin = new Administrator();
        Connection::getInstanceWithoutSession()->establishConnection('admin','$iutinfo',Role::Administrator);
        $this->tournoi = new Tournament();
    } 
    //test

    /**
     * @throws Exception
     */
    public function testGeneratePools(): void
    {
        $idJeu = 8;
        $dao=new AdminDAO();
        $dao2=new TeamDAO();
        $dao3=new UserDAO();
        $this->admin->createTournament('test',100,'Local','Toulouse','15:00','25/05/2023',array($idJeu));
        $id = $dao->selectTournamentByName('test');

        $this->tournoi->allTournaments();
        $t = $this->tournoi->getTournament(end($id)['IdTournoi'] - '0');
        Connection::getInstanceWithoutSession()->disconnect();
        Connection::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Team);
        $idE=$dao2->selectTeamIdByGame($idJeu);
        $i = 0;
        while($i < 16){
            $this->equipe = Team::getTeam($idE[$i]['IdEquipe']);
            // TODO: FIX THIS MF
            $this->equipe->register($t,1);
            $i++;
        }
        $id = $t->getIdTournament();
        $totalPools=$dao3->selectnumberPools($idJeu,$id);
        $listePools = $t->getPools();
        assertSame($totalPools[0]['total']-'0', count($listePools[$idJeu]));
    }
    //test
    public function testgenerateFinalPool(): void
    {
        $idJeu = 8;
        $dao=new UserDAO();
        $this->admin->createTournament('test',100,'Local','Toulouse','15:00','25/05/2023',array($idJeu));
        $id = $this->mysql->select('IdTournoi','Tournois','where NomTournoi = "test"');
        $this->tournoi->allTournaments();
        $t = $this->tournoi->getTournament($id[0]['IdTournoi']);
        Connection::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Team);
        $idE = $this->mysql->select('IdEquipe','Equipe','where IdJeu = '.$idJeu);
        $i = 0;
        while($i < 16){
            $this->equipe = Team::getTeam($idE[$i]['IdEquipe']);
            $this->equipe->register($t);
            $i++;
        }
        $id = $t->getIdTournament();
        $Pools = $t->getPools()[$idJeu];
        foreach($Pools as $p){
            $matchs = $p->getMatchs();
            $j = 0;
            $idp = ($p->getId() - '0');
            foreach($matchs as $m){
                // keys of teams
                $keys = array_keys($m->getEquipes());
                MatchJ::setScore($Pools,(int)$idp,$keys[0],$keys[1],random_int(0,$j+3),random_int(0,$j+4));
                $j++;
                if ($j == 5) {
                    $Pools = $t->getPools()[$idJeu];
                }
            }
        }
        //$t->generateFinalPool($id,$idJeu);
        $listePools = $t->getPools()[$idJeu];
        $totalPools=$dao->selectnumberPools($idJeu,$id);
        assertSame($totalPools[0]['total']-'0', count($listePools));
        assertSame(5, count($listePools));
    }
}
?>