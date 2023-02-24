<!--Contrôleur-->
<!--parametre "page" pour recup qu'elle page on est-->
<?php
require_once('./model/Connexion.php');
require_once('./model/Tournois.php');
require_once('./model/Administrateur.php');
require_once('./model/Game.php');
require_once('./model/Ecurie.php');
require_once('./model/');
require_once('./model/Equipes.php');
require_once('./model/Classement.php');
$Admin = new Administrateur();
$connx = Connexion::getInstance();
$mysql = DAO::getInstance();
$Tournois = new Tournois();
if (isset($_GET['sedeconnecter'])) {
    $connx->disconnect();
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'accueil':
            require('./view/headervue.php');
            $buffer='./view/accueilvue.php';
            $tampon=str_replace("##CREERTOURNOI##","<button class='buttonM' onclick='window.location.href='./index.php?page=creertournoi''>Créer Tournoi</button>",$buffer);
            $tampon2=str_replace("##CREERECURIE##","<button class='buttonM' onclick='window.location.href='./index.php?page=creerecurie''>Créer Ecurie</button>",$buffer);
            ob_start($tampon,$tampon2);
            require('./view/accueilvue.php');
            ob_end_flush();
            break;
        case 'connexionvue':
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $connx->establishConnection($_POST['username'], $_POST['password'], $_POST['roles']);
                if ($connx->getRole() == $_POST['roles']) {
                    header("Location: ./index.php?page=accueil");
                } else {
                    header("Location: ./index.php?page=connexionvue&conn=0");
                }
            }
            require('./view/connexionvue.php');
            break;
        case 'listetournoi':
            $liste = $Tournois->allTournaments();
            if (
                isset($_GET['jeu']) || isset($_GET['nom']) || isset($_GET['prixmin']) || isset($_GET['prixmax'])
                || isset($_GET['notoriete']) || isset($_GET['lieu']) || isset($_GET['date'])
            ) {
                $jeu = "";
                $nom = "";
                $date = "";
                $lieu = "";
                $notoriete = "";
                if ($_GET['jeu']) {
                    $jeu = $_GET['jeu'];
                }
                if ($_GET['nom']) {
                    $nom = $_GET['nom'];
                }
                if ($_GET['date']) {
                    $date = $_GET['date'];
                }
                if ($_GET['notoriete']) {
                    $notoriete = $_GET['notoriete'];
                }
                if ($_GET['lieu']) {
                    $lieu = $_GET['lieu'];
                }
                try {
                    $liste = $Tournois->tournoiDe($jeu, $nom, (int)$_GET['prixmin'], (int)$_GET['prixmax'], $notoriete, $lieu, $date);
                } catch (Exception $e) {
                    $e->getMessage(); // to verify
                }
            }
            require('./view/headervue.php');
            require('./view/listetournoisvue.php');
            break;
        case 'classement':
            $listeJeux = Game::allGames();
            $Classement = null;
            if(isset($_GET['jeuC'])){
                $Classement = new Classement($_GET['jeuC']);
                $jeu = Game::getJeuById($_GET['jeuC']);
                $Classement->returnRanking($jeu->getId());
                $listeEquipes = $Classement->getClassement();
            }
            require('./view/headervue.php');
            require('./view/classementvue.php');
            break;
        case 'creerecurie':
            require('./view/headervue.php');
            //if we are not connected as admin then we are redirected to the home page
            if ($connx->getRole() != Role::Administrateur) {
                header('Location: ./index.php?page=accueil');
            }
            if (isset($_POST['submit'])) {
                $Admin->creerEcurie($_POST['name'], $_POST['username'], $_POST['password'], $_POST['typeE']);
                header('Location: ./index.php?page=accueil');
            }
            require('./view/creerecurievue.php');
            break;
        case 'creerequipe':
            require('./view/headervue.php');
            require('./view/creerequipevue.php');
            if ($connx->getRole() == Role::Ecurie) {
                $id = Ecurie::getIDbyAccountName($connx->getIdentifiant());
            }
            $listeJeux = Game::JeuEquipeNJ($id);
            if (isset($_POST['submit'])) {
                if ($connx->getRole() == Role::Ecurie) {
                    $Ecurie = Ecurie::getOrganization($id);
                    $Ecurie->createTeam($_POST['name'], $_POST['username'], $_POST['password'], $_POST['jeuE'], Ecurie::getIDbyAccountName($connx->getIdentifiant()));
                    $IdEquipe = Team::getIDbyname($_POST['name']);
                    for($i=0;$i<4;$i++){
                        if (!empty($_POST['pseudo'.$i])) {
                            $Ecurie->createPlayer($_POST['pseudo'.$i], $_POST['nat'.$i], $IdEquipe);}
                    }
                }
            }
            break;
        case 'creertournoi':
            require('./view/headervue.php');
            $listeJeux = Game::allGames();
            $date = date('Y-m-d', strtotime('+1 month'));
            //Checks if the user is connected and if he is an admin
            if ($connx == null || $connx->getRole() != Role::Administrateur) {
                header('Location: ./index.php?page=accueil');
            }
            if (isset($_POST['submit'])) {
                $cash = $_POST['cashprize'];
                if ($cash < 0) {
                    $cash = 0;
                }
                $Admin->creerTournoi($_POST['name'], $cash, $_POST['typeT'], $_POST['lieu'], $_POST['heure'], $_POST['date'], $_POST['jeuT']);
                header('Location: ./index.php?page=accueil');
            }
            require('./view/creertournoivue.php');
            break;
        case 'listeequipe':
            require('./view/headervue.php');
            $identifiant = $connx->getIdentifiant();
            $Equipes = new Equipes();
            if ($connx->getRole() == Role::Ecurie) {
                $id = Ecurie::getIDbyAccountName($identifiant);
                $listeE = $Equipes->selectEquipe("=" . $id);
            }
            $listeE2 = $Equipes->toutesLesEquipes();
            require('./view/listeequipevue.php');
            break;
        case 'detailstournoi':
            require('./view/headervue.php');
            $idTournoi = null;
            if (isset($_GET['IDT'])) {
                $idTournoi = $_GET['IDT'];
            } else {
                header('Location: ./index.php?page=listetournoi');
            }
            $Tournois->allTournaments();
            $tournoi = $Tournois->getTournoi($idTournoi);
            $poulesJeux  =  $tournoi->getPoules();
            if (isset($_GET['inscrire'])) {
                $idEquipe = $_GET['inscrire'];
                $equipe = Equipe::getEquipe($idEquipe);
                try {
                    $equipe->inscrire($tournoi);
                } catch (Exception $e) {
                    $e->getMessage(); // to verify
                }
            }
            if (isset($_GET['IDJ'])) {
                header('Location:./index.php?page=score&IDJ=' . $_GET['IDJ'] . '&NomT=' . $_GET['NomT'] . '&JeuT=' . $_GET['JeuT'] . '&valide');
                exit();
            }
            require('./view/detailstournoivue.php');
            break;
        case 'detailsequipe':
            require('./view/headervue.php');
            $Equipes = new Equipes();
            $Equipe = $Equipes->getEquipe($_GET['IDE']);
            $Joueurs = $Equipe->getJoueurs($_GET['IDE']);
            require('./view/detailsequipevue.php');
            break;
        case 'score':
            $listePoules = null;
            $nomTournoi = null;
            $nomJeu = null;
            $idJeu = null;
            if (isset($_GET['valide'])) {
                echo '<script>alert("Score enregistré")</script>';
            }
            if (isset($_GET['IDJ'])) {
                $listePoules = $_SESSION['jeu' . $_GET['IDJ']];
                $nomTournoi = $_GET['NomT'];
                $nomJeu = $_GET['JeuT'];
                $idJeu = $_GET['IDJ'];
            } else {
                $listePoules = array();
                $nomTournoi = "Inconnu";
                $nomJeu = 'Game Inconnu';
                $idJeu = null;
            }
            // //uncomment to test
            // if(isset($_GET['test'])){
            //     Connexion::getInstanceWithoutSession()->establishConnection('admin','$iutinfo',Role::Administrateur);
            //     $tournoi = new Tournois();
            //     $pdo = DAO::getInstance()->getPDO();
            //     $pdo->beginTransaction();
            //     $idJeu = 8;
            //     $admin = new Administrateur();
            //     $admin->creerTournoi('test',100,'Local','Toulouse','15:00','25/01/2023',array($idJeu));
            //     $id = $mysql->select('IdTournoi','Tournois','where NomTournoi = "test"');
            //     $tournoi->allTournaments();
            //     $t = $tournoi->getTournoi($id[0]['IdTournoi']);
            //     Connexion::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
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
            //         $t->genererLesPoules($idJeu);
            //     }
            //     // if test = 2, on set les scores des matchs
            //     if($_GET['test'] === '2'){
            //         $poules = $t->getPoules()[$idJeu];
            //         foreach($poules as $p){
            //             $matchs = $p->getMatchs();
            //             $j = 0;
            //             foreach($matchs as $m){
            //                 // keys of teams
            //                 $keys = array_keys($m->getEquipes());
            //                 MatchJ::setScore($poules,$p->getId(),$keys[0],$keys[1],rand(0,$j+3),rand(0,$j+4));
            //                 $j++;
            //                 if ($j === 5) {
            //                     $poules = $t->getPoules()[$idJeu];
            //                 }
            //             }
            //         }
            //     }
            //     $listePoules = $t->getPoules();
            //     $nomTournoi = $t->getNom();
            //     $nomJeu = $t->getJeux()[$idJeu]->getNom();
            //     $pdo->rollBack();
            // }
            $saisirScore = false;
            if ($connx->getRole() == Role::Arbitre && isset($listePoules[$idJeu])) {
                $pouleFinaleExiste = false;
                foreach ($listePoules[$idJeu] as $poule) {
                    if ($poule->estPouleFinale()) {
                        $pouleFinaleExiste = true;
                        if (!$poule->checkIfAllScoreSet()) {
                            $saisirScore = true;
                        }
                    }
                }
                if (!$pouleFinaleExiste) {
                    $saisirScore = true;
                }
            }
            require('./view/headervue.php');
            require('./view/scorevue.php');
            break;
        case 'saisirscore':
            $listePoules = null;
            $nomTournoi = null;
            $nomJeu = null;
            $idJeu = null;
            if(isset($_GET['IDJ'])){
                $listePoules = $_SESSION['jeu'.$_GET['IDJ']];
                $nomTournoi = $_GET['NomT'];
                $nomJeu = $_GET['JeuT'];
                $idJeu = $_GET['IDJ'];
            }else{
                $listePoules = array();
                $nomTournoi = "Inconnu";
                $nomJeu = 'Game Inconnu';
                $idJeu = null;
            }
            if(isset($_GET['score1']) && isset($_GET['score2'])){
                try{
                    MatchJ::setScore($listePoules[$idJeu],$_GET['poule'],$_GET['equipe1'], $_GET['equipe2'], $_GET['score1'],$_GET['score2']);
                    $tournoi = new Tournois();
                    $tournoi->allTournaments();
                    $idT = MatchJ::getIdTournoi($_GET['poule']);
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
            require('./view/headervue.php');
            require('./view/saisirscorevue.php');
            break;
        default:
            require('./view/headervue.php');
            require('./view/accueilvue.php');
            break;
    }
} else {
    require('./view/headervue.php');
    require('./view/accueilvue.php');
}
?>