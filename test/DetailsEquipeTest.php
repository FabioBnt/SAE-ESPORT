<?php 
declare(strict_types=1);
use function PHPUnit\Framework\assertSame;
include_once(dirname(__DIR__).'/modele/Equipe.php');
//créer un test details tournoi
class DetailsEquipeTest extends \PHPUnit\Framework\TestCase {
    private $mysql;
    //mettre en place
    protected function setUp(): void {
        $this->mysql = Database::getInstance();
    } 
    //test
    public function testnbtournoigagneEquipe() {
        $pdo = $this->mysql->getPDO();
        $pdo->beginTransaction();
        $idJeu = 8;
        $this->admin->creerTournoi('test',100,'Local','Toulouse','15:00','25/05/2023',array($idJeu));
        $id = $this->mysql->select('IdTournoi','Tournois','where NomTournoi = "test"');
        $this->tournoi->tousLesTournois();
        $t = $this->tournoi->getTournoi($id[0]['IdTournoi']);
        Connexion::getInstanceSansSession()->seConnecter('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
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
        foreach($t->getPoules()[$idJeu] as $poule){
            $matchs = $p->getMatchs();
            $idp = ($p->getId() - '0');
            if($poule->estPouleFinale()){
                $keys = array_keys($poule->lesEquipes());
                $equipe = $poule->lesEquipes()[$keys[0]];
                $nbTng= $equipe->getNbmatchG();
                $gainTng = $equipe->SommeTournoiG();
                foreach($matchs as $m){
                    // keys of teams
                    $keys = array_keys($m->getEquipes());
                    if($keys[0]==$equipe){
                        MatchJ::setScore($poules,$idp,$keys[0],$keys[1],5,0);
                    } else if($keys[1]==$equipe){
                        MatchJ::setScore($poules,$idp,$keys[0],$keys[1],0,5);
                    } else {
                        MatchJ::setScore($poules,$idp,$keys[0],$keys[1],random_int(0,$j+3),random_int(0,$j+4));
                    }
                    $j++;
                }
            }
        }
        $nbTournoiG = $equipe->getNbmatchG();
        $gainTournoiG = $equipe->SommeTournoiG();
        assertSame($nbTournoiG,$nbTng+1);
        assertSame($gainTournoiG,$gainTng+100);
    }
    //test
    public function testgaintournoiEquipe() {
        $id = '24';
        $gainTournoireq =154000;
        $gainTournoiG = $equipe->SommeTournoiG();
        assertSame($gainTournoiG,$gainTournoireq);
    }
}
?>