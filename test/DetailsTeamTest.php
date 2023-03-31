<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Exception;
use function PHPUnit\Framework\assertSame;

require_once('./model/Administrator.php');
require_once ('./model/Tournament.php');
require_once ('./model/Connection.php');
require_once ('./model/Game.php');
require_once ('./model/Team.php');
require_once ('./dao/AdminDAO.php');
require_once ('./dao/TeamDAO.php');
//create a details team test
class DetailsTeamTest extends TestCase {
    private Tournament $tournoi;
    private Administrator $admin;
    private Team $equipe;
    private Connection $user;
    //set up

    /**
     */
    protected function setUp(): void {
        $this->admin = new Administrator();
        $this->user = Connection::getInstanceWithoutSession();
        $this->tournoi = new Tournament();
    }

//tear down
    protected function tearDown(): void
    {
        $this->user->disconnect();
    }

    //test

    /**
     * @throws Exception
     */
    public function testnumberTournamentWin(): void
    {
        $idGame = 1;
        $dao =new AdminDAO();
        $dao->getConnection()->beginTransaction();
        $this->admin->createTournament('test',100,'Local','Toulouse','15:00','25/05/2023',array($idGame));
        $daoT =new TeamDAO();
        $id = $dao->selectTournamentByName('test');
        $this->tournoi->allTournaments();
        $t = $this->tournoi->getTournament(end($id)['IdTournoi']);
        $this->user->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Team);
        $idE=$daoT->selectTeamIdByGame($idGame);
        $i = 0;
        while($i < 16){
            $this->equipe = Team::getTeam($idE[$i]['IdEquipe']);
            $this->equipe->register($t,1);
            $i++;
        }
        $id = $t->getIdTournament();
        $Pools = $t->getPools()[$idGame];
        // last team
        $equipeT = $this->equipe;
        $nbTng = $equipeT->getNbmatchWin();
        $gainTng = $equipeT->sumTournamentWin();
        foreach($Pools as $p) {
            $matchs = $p->getMatchs();
            $j = 0;
            $idp = ($p->getId() - '0');
            foreach ($matchs as $m) {
                // keys of teams
                $keys = array_keys($m->getEquipes());
                if ($keys[0] === $equipeT->getId()) {
                    MatchJ::setScore($Pools, $idp, $keys[0], $keys[1], 5, 0);
                } else if ($keys[1] === $equipeT->getId()) {
                    MatchJ::setScore($Pools, $idp, $keys[0], $keys[1], 0, 5);
                } else {
                    MatchJ::setScore($Pools, $idp, $keys[0], $keys[1], random_int(0, $j + 3), random_int(0, $j + 4));
                }
                $j++;
                if ($j === 5) {
                    $Pools = $t->getPools()[$idGame];
                }
            }
        }
        // select count of Pools
        // force generation of Pool finale
        $t->generateFinalPool($id, $idGame);
        $Pools = $t->getPools()[$idGame];
        foreach($Pools as $p) {
            $matchs = $p->getMatchs();
            $j = 0;
            $idp = ($p->getId() - '0');
            if ($p->isPoolFinale()) {
                foreach ($matchs as $m) {
                    // keys of teams
                    $keys = array_keys($m->getEquipes());
                    if ($keys[0] === $equipeT->getId()) {
                        MatchJ::setScore($Pools, $idp, $keys[0], $keys[1], 5, 0);
                    } else if ($keys[1] === $equipeT->getId()) {
                        MatchJ::setScore($Pools, $idp, $keys[0], $keys[1], 0, 5);
                    } else {
                        MatchJ::setScore($Pools, $idp, $keys[0], $keys[1], random_int(0, $j + 3), random_int(0, $j + 4));
                    }
                    $j++;
                    if ($j === 5) {
                        $Pools = $t->getPools()[$idGame];
                    }
                }
            }
        }
        $nbTournoiG = $equipeT->getNbmatchWin();
        $gainTournoiG = $equipeT->sumTournamentWin();
        $dao->getConnection()->rollBack();
        assertSame($nbTournoiG,$nbTng+1);
        assertSame($gainTournoiG,$gainTng+100);
    }
}
?>