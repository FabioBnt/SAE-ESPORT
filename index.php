<!--Contrôleur-->
<!--parametre "page" pour recup qu'elle page on est-->
<?php
require_once('./model/Connection.php');
require_once('./model/Administrator.php');
require_once('./model/Game.php');
require_once('./model/Organization.php');
require_once('./model/Tournament.php');
require_once('./model/Team.php');
require_once('./model/Classement.php');
$Admin = new Administrator();
$connx = Connection::getInstance();
$Tournament = new Tournament();
if (isset($_GET['sedeconnecter'])) {
    $connx->disconnect();
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'accueil':
            require('./view/headerview.php');
            $buffer='./view/accueilview.php';
            $tampon=str_replace("##CREERTOURNOI##","<button class='buttonM' onclick='window.location.href='./index.php?page=creertournoi''>Créer Tournoi</button>",$buffer);
            $tampon2=str_replace("##CREERECURIE##","<button class='buttonM' onclick='window.location.href='./index.php?page=creerOrganization''>Créer Ecurie</button>",$buffer);
            ob_start($tampon,$tampon2);
            require('./view/accueilview.php');
            ob_end_flush();
            break;
        case 'connectionview':
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $connx->establishConnection($_POST['username'], $_POST['password'], $_POST['roles']);
                if ($connx->getRole() == $_POST['roles']) {
                    header("Location: ./index.php?page=accueil");
                } else {
                    header("Location: ./index.php?page=connectionview&conn=0");
                }
            }
            require('./view/connectionview.php');
            break;
        case 'listetournoi':
            $liste = $Tournois->allTournaments();
            if (
                isset($_GET['jeu']) || isset($_GET['nom']) || isset($_GET['prixmin']) || isset($_GET['prixmax'])
                || isset($_GET['Notoriety']) || isset($_GET['lieu']) || isset($_GET['date'])
            ) {
                $jeu = "";
                $nom = "";
                $date = "";
                $lieu = "";
                $Notoriety = "";
                if ($_GET['jeu']) {
                    $jeu = $_GET['jeu'];
                }
                if ($_GET['nom']) {
                    $nom = $_GET['nom'];
                }
                if ($_GET['date']) {
                    $date = $_GET['date'];
                }
                if ($_GET['Notoriety']) {
                    $Notoriety = $_GET['Notoriety'];
                }
                if ($_GET['lieu']) {
                    $lieu = $_GET['lieu'];
                }
                try {
                    $liste = $Tournois->tournoiDe($jeu, $nom, (int)$_GET['prixmin'], (int)$_GET['prixmax'], $Notoriety, $lieu, $date);
                } catch (Exception $e) {
                    $e->getMessage(); // to verify
                }
            }
            require('./view/headerview.php');
            require('./view/listetournoisview.php');
            break;
        case 'classement':
            $listeJeux = Game::allGames();
            $Classement = null;
            if(isset($_GET['jeuC'])){
                $Classement = new Classement($_GET['jeuC']);
                $jeu = Game::getGameById($_GET['jeuC']);
                $Classement->returnRanking($jeu->getId());
                $listeEquipes = $Classement->getClassement();
            }
            require('./view/headerview.php');
            require('./view/classementview.php');
            break;
        case 'creerecurie':
            require('./view/headerview.php');
            //if we are not connected as admin then we are redirected to the home page
            if ($connx->getRole() != Role::Administrator) {
                header('Location: ./index.php?page=accueil');
            }
            if (isset($_POST['submit'])) {
                $Admin->createOrganization($_POST['name'], $_POST['username'], $_POST['password'], $_POST['typeE']);
                header('Location: ./index.php?page=accueil');
            }
            require('./view/creerecurieview.php');
            break;
        case 'creerequipe':
            require('./view/headerview.php');
            require('./view/creerequipeview.php');
            if ($connx->getRole() == Role::Organization) {
                $id = Organization::getIDbyAccountName($connx->getIdentifiant());
            }
            $listeJeux = Game::getGameTeamNotPlayed($id);   
            if (isset($_POST['submit'])) {
                if ($connx->getRole() == Role::Organization) {
                    $Organization = Organization::getOrganization($id);
                    $Organization->createTeam($_POST['name'], $_POST['username'], $_POST['password'], $_POST['jeuE'], Organization::getIDbyAccountName($connx->getIdentifiant()));
                    $IdEquipe = Team::getIDbyname($_POST['name']);
                    for($i=0;$i<4;$i++){
                        if (!empty($_POST['pseudo'.$i])) {
                            $Organization->createPlayer($_POST['pseudo'.$i], $_POST['nat'.$i], $IdEquipe);}
                    }
                }
            }
            break;
        case 'creertournoi':
            require('./view/headerview.php');
            $listeJeux = Game::allGames();
            $date = date('Y-m-d', strtotime('+1 month'));
            //Checks if the user is connected and if he is an admin
            if ($connx == null || $connx->getRole() != Role::Administrator) {
                header('Location: ./index.php?page=accueil');
            }
            if (isset($_POST['submit'])) {
                $cash = $_POST['cashprize'];
                if ($cash < 0) {
                    $cash = 0;
                }
                $Admin->createTournament($_POST['name'], $cash, $_POST['typeT'], $_POST['lieu'], $_POST['heure'], $_POST['date'], $_POST['jeuT']);
                header('Location: ./index.php?page=accueil');
            }
            require('./view/creertournoiview.php');
            break;
        case 'listeequipe':
            require('./view/headerview.php');
            $identifiant = $connx->getIdentifiant();
            $Equipes = new Team();
            if ($connx->getRole() == Role::Organization) {
                $id = Organization::getIDbyAccountName($identifiant);
                $listeE = $Equipes->getTeamList($id);
            }
            $listeE2 = $Equipes->getTeamList();
            require('./view/listeequipeview.php');
            break;
        case 'detailstournoi':
            require('./view/headerview.php');
            $idTournoi = null;
            if (isset($_GET['IDT'])) {
                $idTournoi = $_GET['IDT'];
            } else {
                header('Location: ./index.php?page=listetournoi');
            }
            $Tournois->allTournaments();
            $tournoi = $Tournois->getTournament($idTournoi);
            $PoolsJeux  =  $tournoi->getPools();
            if (isset($_GET['inscrire'])) {
                $idEquipe = $_GET['inscrire'];
                $equipe = Team::getTeam($idEquipe);
                try {
                    $equipe->register($tournoi);
                } catch (Exception $e) {
                    $e->getMessage(); // to verify
                }
            }
            if (isset($_GET['IDJ'])) {
                header('Location:./index.php?page=score&IDJ=' . $_GET['IDJ'] . '&NomT=' . $_GET['NomT'] . '&JeuT=' . $_GET['JeuT'] . '&valide');
                exit();
            }
            $nomCompteEquipe = $connx->getIdentifiant();
            $idEquipe=Team::getTeamIDByAccountName($id);
            $equipe = Team::getTeam($idEquipe);
            require('./view/detailstournoiview.php');
            break;
        case 'detailsequipe':
            require('./view/headerview.php');
            $Equipes = new Team();
            $Equipe = $Equipes->getTeam($_GET['IDE']);
            $Joueurs = $Equipe->getPlayers($_GET['IDE']);
            $listeTournois = new Tournament();
            $data=$listeTournois->tournamentsParticipatedByTeam($_GET['IDE']);
            require('./view/detailsequipeview.php');
            break;
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
                    $tournoi = new Tournament();
                    $tournoi->allTournaments();
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
            require('./view/headerview.php');
            require('./view/accueilview.php');
            break;
    }
} else {
    require('./view/headerview.php');
    require('./view/accueilview.php');
}
?>