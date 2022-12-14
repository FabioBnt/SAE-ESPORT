<?php declare(strict_types=1);

use function PHPUnit\Framework\assertSame;

include_once(dirname(__DIR__).'/modele/Tournois.php');
class GenererPoulesTest extends \PHPUnit\Framework\TestCase {
    private $mysql;
    private $tournoi;
    private $admin;
    private $equipe;
    protected function setUp(): void {
        $this->mysql = Database::getInstance();
        $this->admin = new Administrateur();
        Connexion::getInstanceSansSession()->seConnecter('admin','$iutinfo',Role::Administrateur);
        $this->tournoi = new Tournois();
    } 

    public function testGenererPoules(){
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
        $t->genererLesPoules($idJeu);
        $id = $t->getIdTournoi();
        $totalPoules = $this->mysql->select("count(*) as total", "Poule", "where IdTournoi = $id");
        $listePoules = $t->getPoules();
        $pdo->rollBack();
        assertSame($totalPoules[0]['total']-'0', 4);
        
    }

}