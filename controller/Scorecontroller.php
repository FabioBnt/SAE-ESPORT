<?php
$connx = Connection::getInstance();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'score':
            require_once('./codereplacer/scoreCodeReplace.php');
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
            if (isset($_GET['valide'])) {
                echo '<script>alert("Score enregistré")</script>';
            }
            if (isset($_GET['erreur'])) {
                echo '<script>alert("Erreur lors de l\'enregistrement du score")</script>';
            }
            require_once('./view/headerview.html');
            ob_start('scoreCodeReplace');
            require_once('./view/scoreview.html');
            ob_end_flush();
            break;
        case 'saisirscore':
            $listePools = null;
            if (isset($_GET['IDJ'])) {
                $listePools = $_SESSION['jeu' . $_GET['IDJ']];
            } else {
                $listePools = array();
            }
            if (isset($_GET['score1']) && isset($_GET['score2'])) {
                try {
                    MatchJ::setScore($listePools, $_GET['poule'], $_GET['equipe1'], $_GET['equipe2'], $_GET['score1'], $_GET['score2']);
                    $Tournament->allTournaments();
                    $idT = MatchJ::getIdTournamentByPool($_GET['poule']);
                    exit();
                } catch (Exception $e) {
                    exit();
                }
            }
            // si erreur
            if (isset($_GET['erreur'])) {
                echo '<script>alert("' . $_GET['erreur'] . '")</script>';
            }
            echo "ligne inserée";
            break;
        default:
            require_once('./controller/Accueilcontroller.php');
            break;
    }
} else {
    require_once('./controller/Accueilcontroller.php');
}
?>