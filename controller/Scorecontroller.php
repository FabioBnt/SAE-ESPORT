<?
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'score':
            $listePools = null;
            $nomTournoi = null;
            $nomJeu = null;
            $idJeu = null;
            if (isset($_GET['valide'])) {
                echo '<script>alert("Score enregistré")</script>';
            }
            if (isset($_GET['IDJ'])) {
                $listePools = $_SESSION['jeu' . $_GET['IDJ']];
                $nomTournoi = $_GET['NomT'];
                $nomJeu = $_GET['JeuT'];
                $idJeu = $_GET['IDJ'];
            } else {
                $listePools = array();
                $nomTournoi = "Inconnu";
                $nomJeu = 'Jeu Inconnu';
                $idJeu = null;
            }
            // //uncomment to test
            // if(isset($_GET['test'])){
            //     Connection::getInstanceWithoutSession()->establishConnection('admin','$iutinfo',Role::Administrator);
            //     $tournoi = new Tournois();
            //     $pdo = DAO::getInstance()->getPDO();
            //     $pdo->beginTransaction();
            //     $idJeu = 8;
            //     $admin = new Administrator();
            //     $admin->creerTournoi('test',100,'Local','Toulouse','15:00','25/01/2023',array($idJeu));
            //     $id = $mysql->select('IdTournoi','Tournois','where NomTournoi = "test"');
            //     $tournoi->allTournaments();
            //     $t = $tournoi->getTournament($id[0]['IdTournoi']);
            //     Connection::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
            //     $idE = $mysql->select('IdEquipe','Equipe','where IdJeu = '.$idJeu);
            //     $i = 0;
            //     $maxE = 16;
            //     if($_GET['test'] === '1'){
            //         $maxE = 14;
            //     }
            //     while($i < $maxE){
            //         $equipe = Equipe::getEquipe($idE[$i]['IdEquipe']);
            //         $equipe->Inscrire($t);
            //         $i++;
            //     }
            //     if($_GET['test'] === '1'){
            //         $t->genererLesPools($idJeu);
            //     }
            //     // if test = 2, on set les scores des matchs
            //     if($_GET['test'] === '2'){
            //         $Pools = $t->getPools()[$idJeu];
            //         foreach($Pools as $p){
            //             $matchs = $p->getMatchs();
            //             $j = 0;
            //             foreach($matchs as $m){
            //                 // keys of teams
            //                 $keys = array_keys($m->getEquipes());
            //                 MatchJ::setScore($Pools,$p->getId(),$keys[0],$keys[1],rand(0,$j+3),rand(0,$j+4));
            //                 $j++;
            //                 if ($j === 5) {
            //                     $Pools = $t->getPools()[$idJeu];
            //                 }
            //             }
            //         }
            //     }
            //     $listePools = $t->getPools();
            //     $nomTournoi = $t->getNom();
            //     $nomJeu = $t->getJeux()[$idJeu]->getNom();
            //     $pdo->rollBack();
            // }
            $saisirScore = false;
            if ($connx->getRole() == Role::Arbitre && isset($listePools[$idJeu])) {
                $PoolFinaleExiste = false;
                foreach ($listePools[$idJeu] as $Pool) {
                    if ($Pool->isPoolFinale()) {
                        $PoolFinaleExiste = true;
                        if (!$Pool->checkIfAllScoreSet()) {
                            $saisirScore = true;
                        }
                    }
                }
                if (!$PoolFinaleExiste) {
                    $saisirScore = true;
                }
            }
            require('./view/headerview.php');
            require('./view/scoreview.php');
            break;
        case 'saisirscore':
            $listePools = null;
            $nomTournoi = null;
            $nomJeu = null;
            $idJeu = null;
            if(isset($_GET['IDJ'])){
                $listePools = $_SESSION['jeu'.$_GET['IDJ']];
                $nomTournoi = $_GET['NomT'];
                $nomJeu = $_GET['JeuT'];
                $idJeu = $_GET['IDJ'];
            }else{
                $listePools = array();
                $nomTournoi = "Inconnu";
                $nomJeu = 'Jeu Inconnu';
                $idJeu = null;
            }
            if(isset($_GET['score1']) && isset($_GET['score2'])){
                try{
                    MatchJ::setScore($listePools[$idJeu],$_GET['poule'],$_GET['equipe1'], $_GET['equipe2'], $_GET['score1'],$_GET['score2']);
                    $Tournament->allTournaments();
                    $idT = MatchJ::getIdTournamentByPool($_GET['poule']);
                    //vers DetailsTournoi.php?IDT=
                    header( 'Location:./index.php?page=detailstournoi&IDT='.$idT.'&IDJ='.$idJeu.'&NomT='.$nomTournoi.'&JeuT='.$nomJeu);
                    exit();
                }catch(Exception $e){
                    // redirect vers la page de SaissirScore.php
                    header('Location:./saisirscore.php?IDJ='.$idJeu.'&NomT='.$nomTournoi.'&JeuT='.$nomJeu.'&erreur='.$e->getMessage());
                    exit();
                }
            }
            // si erreur
            if(isset($_GET['erreur'])){
                echo '<script>alert("'.$_GET['erreur'].'")</script>';
            }
            require('./view/headerview.php');
            require('./view/saisirscoreview.php');
            break;
        default:
            require('./controller/Accueilcontroller.php');
            break;
    }
} else {
    require('./controller/Accueilcontroller.php');
}
?>