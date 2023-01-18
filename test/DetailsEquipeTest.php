<?php 
use function PHPUnit\Framework\assertSame;
include_once(dirname(__DIR__).'/modele/Equipe.php');
include_once(dirname(__DIR__).'/modele/Administrateur.php');
include_once (dirname(__DIR__).'/modele/Tournois.php');
//créer un test details tournoi
class DetailsEquipeTest extends \PHPUnit\Framework\TestCase {
    private $mysql;
    private Tournois $tournoi;
    private Administrateur $admin;
    private Equipe $equipe;
    //mettre en place
    protected function setUp(): void {
        $this->mysql = Database::getInstance();
        $this->admin = new Administrateur();
        Connexion::getInstanceSansSession()->seConnecter('admin','$iutinfo',Role::Administrateur);
        $this->tournoi = new Tournois();
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
        $equipeT = null;
        foreach($poules as $p) {
            $matchs = $p->getMatchs();
            $j = 0;
            $idp = ($p->getId() - '0');
            if ($p->estPouleFinale()==1) {
                $keys = array_keys($p->lesEquipes());
                $equipeT = $p->lesEquipes()[$keys[0]];
                $nbTng = $equipeT->getNbmatchG();
                $gainTng = $equipeT->SommeTournoiG();
                foreach ($matchs as $m) {
                    // keys of teams
                    $keys = array_keys($m->getEquipes());
                    if ($keys[0] === $equipeT) {
                        MatchJ::setScore($poules, $idp, $keys[0], $keys[1], 5, 0);
                    } else if ($keys[1] === $equipeT) {
                        MatchJ::setScore($poules, $idp, $keys[0], $keys[1], 0, 5);
                    } else {
                        MatchJ::setScore($poules, $idp, $keys[0], $keys[1], random_int(0, $j + 3), random_int(0, $j + 4));
                    }
                    $j++;
                }
            } else {
                foreach ($matchs as $m) {
                    // keys of teams
                    $keys = array_keys($m->getEquipes());
                    MatchJ::setScore($poules, $idp, $keys[0], $keys[1], random_int(0, $j + 3), random_int(0, $j + 4));
                    $j++;
                    if ($j == 5) {
                        $poules = $t->getPoules()[$idJeu];
                    }
                }
            }
        }
        $nbTournoiG = $equipeT->getNbmatchG();
        $gainTournoiG = $equipeT->SommeTournoiG();
        assertSame($nbTournoiG,$nbTng+1);
        assertSame($gainTournoiG,$gainTng+100);
    }
}
?>