<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__) . '/model/Tournois.php');
include_once(dirname(__DIR__) . '/model/');
include_once(dirname(__DIR__) . '/model/MatchJ.php');
include_once(dirname(__DIR__) . '/model/Poule.php');
include_once(dirname(__DIR__) . '/model/Administrateur.php');
//créer un test générer poule
class GenererPoulesTest extends TestCase {
    private DAO $mysql;
    private Tournois $tournoi;
    private Administrateur $admin;
    private Equipe $equipe;
    //mettre en place
    protected function setUp(): void {
        $this->mysql = DAO::getInstance();
        $this->admin = new Administrateur();
        Connexion::getInstanceWithoutSession()->establishConnection('admin','$iutinfo',Role::Administrateur);
        $this->tournoi = new Tournois();
    } 
    //test
    public function testGenererPoules(): void
    {
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $idJeu = 8;
        $this->admin->creerTournoi('test',100,'Local','Toulouse','15:00','25/05/2023',array($idJeu));
        $id = $this->mysql->select('IdTournoi','Tournois','where NomTournoi = "test"');
        $this->tournoi->allTournaments();
        $t = $this->tournoi->getTournoi($id[0]['IdTournoi']);
        Connexion::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
        $idE = $this->mysql->select('IdEquipe','Equipe','where IdJeu = '.$idJeu);
        $i = 0;
        while($i < 16){
            $this->equipe = Equipe::getEquipe($idE[$i]['IdEquipe']);
            $this->equipe->Inscrire($t);
            $i++;
        }
        $id = $t->getIdTournoi();
        $totalPoules = $this->mysql->select("count(*) as total", "Poule", "where IdTournoi = $id");
        $listePoules = $t->getPoules();
        $pdo->rollBack();
        // $sum = 0;
        // foreach($listePoules as $poule){
        //     $sum +=  count($poule);
        // }
        assertSame($totalPoules[0]['total']-'0', count($listePoules[$idJeu]));
    }

    /**
     * Test de la génération de la poule finale
     * @throws Exception
     */
    public function testGenererPouleFinale(): void
    {
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $idJeu = 8;
        $this->admin->creerTournoi('test',100,'Local','Toulouse','15:00','25/05/2023',array($idJeu));
        $id = $this->mysql->select('IdTournoi','Tournois','where NomTournoi = "test"');
        $this->tournoi->allTournaments();
        $t = $this->tournoi->getTournoi($id[0]['IdTournoi']);
        Connexion::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
        $idE = $this->mysql->select('IdEquipe','Equipe','where IdJeu = '.$idJeu);
        $i = 0;
        while($i < 16){
            $this->equipe = Equipe::getEquipe($idE[$i]['IdEquipe']);
            $this->equipe->Inscrire($t);
            $i++;
        }
        $id = $t->getIdTournoi();
        $poules = $t->getPoules()[$idJeu];
        foreach($poules as $p){
            $matchs = $p->getMatchs();
            $j = 0;
            $idp = ($p->getId() - '0');
            foreach($matchs as $m){
                // keys of teams
                $keys = array_keys($m->getEquipes());
                MatchJ::setScore($poules,$idp,$keys[0],$keys[1],random_int(0,$j+3),random_int(0,$j+4));
                $j++;
                if ($j == 5) {
                    $poules = $t->getPoules()[$idJeu];
                }
            }
        }
        //$t->genererPouleFinale($id,$idJeu);
        $listePoules = $t->getPoules()[$idJeu];
        $totalPoules = $this->mysql->select("count(*) as total", "Poule", "where IdTournoi = $id");
        $pdo->rollBack();
        assertSame($totalPoules[0]['total']-'0', count($listePoules));
        assertSame(5, count($listePoules));
    }
}
?>