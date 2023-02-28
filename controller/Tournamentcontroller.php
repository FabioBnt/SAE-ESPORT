<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'listetournoi':
            $liste = $Tournament->allTournaments();
            if (
                isset($_GET['jeu']) || isset($_GET['nom']) || isset($_GET['prixmin']) || isset($_GET['prixmax'])
                || isset($_GET['Notoriety']) || isset($_GET['lieu']) || isset($_GET['date'])
            ) {
                // if not empty value of the input else null
                $jeu = !empty($_GET['jeu']) ? $_GET['jeu'] : null;
                $nom = !empty($_GET['nom']) ? $_GET['nom'] : null;
                $prixmin = !empty($_GET['prixmin']) ? $_GET['prixmin'] : null;
                $prixmax = !empty($_GET['prixmax']) ? $_GET['prixmax'] : null;
                $notoriety = !empty($_GET['Notoriety']) ? $_GET['Notoriety'] : null;
                $lieu = !empty($_GET['lieu']) ? $_GET['lieu'] : null;
                $date = !empty($_GET['date']) ? $_GET['date'] : null; 
                try {
                    $liste = $Tournament->tournoiDe($jeu, $nom, $prixmin, $prixmax, $notoriety, $lieu, $date);
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
            if ($connx->getRole() == Role::Team) {
                $idEquipe = Team::getTeamIDByAccountName($nomCompteEquipe);
                $equipe = Team::getTeam($idEquipe);
            }
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