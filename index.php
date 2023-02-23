<!--Contrôleur-->
<!--parametre "page" pour recup qu'elle page on est-->
<?php
require_once('./modele/Connexion.php');
require_once('./modele/Tournois.php');
require_once('./modele/Administrateur.php');
require_once('./modele/Jeu.php');
require_once('./modele/Ecurie.php');
require_once('./modele/Equipe.php');
require_once('./modele/Equipes.php');
require_once('./modele/Classement.php');
$Admin = new Administrateur();
$connx = Connexion::getInstance();
$mysql = Database::getInstance();
$Tournois = new Tournois();
if (isset($_GET['sedeconnecter'])) {
    $connx->seDeconnecter();
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'accueil':
            require('./vue/headervue.php');
            require('./vue/accueilvue.php');
            break;
        case 'connexionvue':
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $connx->seConnecter($_POST['username'], $_POST['password'], $_POST['roles']);
                if ($connx->getRole() == $_POST['roles']) {
                    header("Location: ./index.php?page=accueil");
                } else {
                    header("Location: ./index.php?page=connexionvue&conn=0");
                }
            }
            require('./vue/connexionvue.php');
            break;
        case 'listetournoi':
            $liste = $Tournois->tousLesTournois();
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
            require('./vue/headervue.php');
            require('./vue/listetournoisvue.php');
            break;
        case 'classement':
            $listeJeux = Jeu::tousLesJeux();
            $Classement = null;
            if(isset($_GET['jeuC'])){
                $Classement = new Classement($_GET['jeuC']);
                $jeu = Jeu::getJeuById($_GET['jeuC']);
                $Classement->returnClassement($jeu->getId());
                $listeEquipes = $Classement->getClassement();
            }
            require('./vue/headervue.php');
            require('./vue/classementvue.php');
            break;
        case 'creerecurie':
            require('./vue/headervue.php');
            //if we are not connected as admin then we are redirected to the home page
            if ($connx->getRole() != Role::Administrateur) {
                header('Location: ./index.php?page=accueil');
            }
            if (isset($_POST['submit'])) {
                $Admin->creerEcurie($_POST['name'], $_POST['username'], $_POST['password'], $_POST['typeE']);
                header('Location: ./index.php?page=accueil');
            }
            require('./vue/creerecurievue.php');
            break;
        case 'creerequipe':
            require('./vue/headervue.php');
            require('./vue/creerequipevue.php');
            if ($connx->getRole() == Role::Ecurie) {
                $id = Ecurie::getIDbyNomCompte($connx->getIdentifiant());
            }
            $listeJeux = Jeu::JeuEquipeNJ($id);   
            if (isset($_POST['submit'])) {
                if ($connx->getRole() == Role::Ecurie) {
                    $Ecurie = Ecurie::getEcurie($id);
                    $Ecurie->creerEquipe($_POST['name'], $_POST['username'], $_POST['password'], $_POST['jeuE'], Ecurie::getIDbyNomCompte($connx->getIdentifiant()));
                    $IdEquipe = Equipe::getIDbyNom($_POST['name']);
                    for($i=0;$i<4;$i++){
                        if (!empty($_POST['pseudo'.$i])) {
                            $Ecurie->ajouterJoueur($_POST['pseudo'.$i], $_POST['nat'.$i], $IdEquipe);}
                    }
                }
            }
            break;
        case 'creertournoi':
            require('./vue/headervue.php');
            $listeJeux = Jeu::tousLesJeux();
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
            require('./vue/creertournoivue.php');
            break;
        case 'listeequipe':
            require('./vue/headervue.php');
            $identifiant = $connx->getIdentifiant();
            $Equipes = new Equipes();
            if ($connx->getRole() == Role::Ecurie) {
                $id = Ecurie::getIDbyNomCompte($identifiant);
                $listeE = $Equipes->selectEquipe("=" . $id);
            }
            $listeE2 = $Equipes->toutesLesEquipes();
            require('./vue/listeequipevue.php');
            break;
        case 'detailstournoi':
            require('./vue/headervue.php');
            $idTournoi = null;
            if (isset($_GET['IDT'])) {
                $idTournoi = $_GET['IDT'];
            } else {
                header('Location: ./index.php?page=listetournoi');
            }
            $Tournois->tousLesTournois();
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
            require('./vue/detailstournoivue.php');
            break;
        case 'detailsequipe':
            require('./vue/headervue.php');
            $Equipes = new Equipes();
            $Equipe = $Equipes->getEquipe($_GET['IDE']);
            $Joueurs = $Equipe->getJoueurs($_GET['IDE']);
            require('./vue/detailsequipevue.php');
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
                $nomJeu = 'Jeu Inconnu';
                $idJeu = null;
            }
            // //uncomment to test
            // if(isset($_GET['test'])){
            //     Connexion::getInstanceSansSession()->seConnecter('admin','$iutinfo',Role::Administrateur);
            //     $tournoi = new Tournois();
            //     $pdo = Database::getInstance()->getPDO();
            //     $pdo->beginTransaction();
            //     $idJeu = 8;
            //     $admin = new Administrateur();
            //     $admin->creerTournoi('test',100,'Local','Toulouse','15:00','25/01/2023',array($idJeu));
            //     $id = $mysql->select('IdTournoi','Tournois','where NomTournoi = "test"');
            //     $tournoi->tousLesTournois();
            //     $t = $tournoi->getTournoi($id[0]['IdTournoi']);
            //     Connexion::getInstanceSansSession()->seConnecter('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
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
            require('./vue/headervue.php');
            require('./vue/scorevue.php');
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
                $nomJeu = 'Jeu Inconnu';
                $idJeu = null;
            }
            if(isset($_GET['score1']) && isset($_GET['score2'])){
                try{
                    MatchJ::setScore($listePoules[$idJeu],$_GET['poule'],$_GET['equipe1'], $_GET['equipe2'], $_GET['score1'],$_GET['score2']);
                    $tournoi = new Tournois();
                    $tournoi->tousLesTournois();
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
            require('./vue/headervue.php');
            require('./vue/saisirscorevue.php');
            break;
        default:
            require('./vue/headervue.php');
            require('./vue/accueilvue.php');
            break;
    }
} else {
    require('./vue/headervue.php');
    require('./vue/accueilvue.php');
}
?>