<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/Tournois.php');
include_once(dirname(__DIR__) . '/model/');
include_once(dirname(__DIR__) . '/model/MatchJ.php');
include_once(dirname(__DIR__) . '/model/Pool.php');
include_once(dirname(__DIR__) . '/model/Administrator.php');
//créer un test générer Pool
class GenererPoolsTest extends TestCase {
    private DAO $mysql;
    private Tournois $tournoi;
    private Administrator $admin;
    private Equipe $equipe;
    //mettre en place
    protected function setUp(): void {
        $this->mysql = DAO::getInstance();
        $this->admin = new Administrator();
        Connection::getInstanceWithoutSession()->establishConnection('admin','$iutinfo',Role::Administrator);
        $this->tournoi = new Tournois();
    } 
    //test
    public function testGenererPools(): void
    {
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $idJeu = 8;
        $this->admin->creerTournoi('test',100,'Local','Toulouse','15:00','25/05/2023',array($idJeu));
        $id = $this->mysql->select('IdTournoi','Tournois','where NomTournoi = "test"');
        $this->tournoi->allTournaments();
        $t = $this->tournoi->getTournament($id[0]['IdTournoi']);
        Connection::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
        $idE = $this->mysql->select('IdEquipe','Equipe','where IdJeu = '.$idJeu);
        $i = 0;
        while($i < 16){
            $this->equipe = Equipe::getEquipe($idE[$i]['IdEquipe']);
            $this->equipe->Inscrire($t);
            $i++;
        }
        $id = $t->getIdTournament();
        $totalPools = $this->mysql->select("count(*) as total", "Poule", "where IdTournoi = $id");
        $listePools = $t->getPools();
        $pdo->rollBack();
        // $sum = 0;
        // foreach($listePools as $Pool){
        //     $sum +=  count($Pool);
        // }
        assertSame($totalPools[0]['total']-'0', count($listePools[$idJeu]));
    }

    /**
     * Test de la génération de la Pool finale
     * @throws Exception
     */
    public function testgenerateFinalPool(): void
    {
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $idJeu = 8;
        $this->admin->creerTournoi('test',100,'Local','Toulouse','15:00','25/05/2023',array($idJeu));
        $id = $this->mysql->select('IdTournoi','Tournois','where NomTournoi = "test"');
        $this->tournoi->allTournaments();
        $t = $this->tournoi->getTournament($id[0]['IdTournoi']);
        Connection::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
        $idE = $this->mysql->select('IdEquipe','Equipe','where IdJeu = '.$idJeu);
        $i = 0;
        while($i < 16){
            $this->equipe = Equipe::getEquipe($idE[$i]['IdEquipe']);
            $this->equipe->Inscrire($t);
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
                MatchJ::setScore($Pools,$idp,$keys[0],$keys[1],random_int(0,$j+3),random_int(0,$j+4));
                $j++;
                if ($j == 5) {
                    $Pools = $t->getPools()[$idJeu];
                }
            }
        }
        //$t->generateFinalPool($id,$idJeu);
        $listePools = $t->getPools()[$idJeu];
        $totalPools = $this->mysql->select("count(*) as total", "Poule", "where IdTournoi = $id");
        $pdo->rollBack();
        assertSame($totalPools[0]['total']-'0', count($listePools));
        assertSame(5, count($listePools));
    }
}
?>