<?
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'listetournoi':
            $liste = $Tournament->allTournaments();
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
                    $liste = $Tournament->tournoiDe($jeu, $nom, (int)$_GET['prixmin'], (int)$_GET['prixmax'], $Notoriety, $lieu, $date);
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
        case 'detailstournoi':
            require('./view/headerview.php');
            $idTournoi = null;
            if (isset($_GET['IDT'])) {
                $idTournoi = $_GET['IDT'];
            } else {
                header('Location: ./index.php?page=listetournoi');
            }
            $Tournament->allTournaments();
            $tournoi = $Tournament->getTournament($idTournoi);
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
        default:
            require('./controller/Accueilcontroller.php');
            break;
    }
} else {
    require('./controller/Accueilcontroller.php');
}
?>