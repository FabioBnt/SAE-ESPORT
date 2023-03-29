<?php
$connx = Connection::getInstance();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'listetournoi':
            require_once('./codereplacer/tournamentCodeReplace.php');
            require_once('./view/headerview.html');
            ob_start('tournamentCodeReplace');
            require_once('./view/listetournoisview.html');
            ob_end_flush();
            break;
        case 'classement':
            require_once('./codereplacer/rankingCodeReplace.php');
            require_once('./view/headerview.html');
            ob_start('rankingCodeReplace');
            require_once('./view/classementview.html');
            ob_end_flush();
            break;
        case 'creertournoi':
            require_once('./codereplacer/createTournamentCodeReplace.php');
            require_once('./view/headerview.html');
            //Checks if the user is connected and if he is an admin
            if ($connx == null || $connx->getRole() != Role::Administrator) {
                header('Location: ./index.php?page=accueil');
            }
            if (isset($_POST['submit'])) {
                $cash = $_POST['cashprize'];
                if ($cash < 0) {
                    $cash = 0;
                }
                $name=htmlspecialchars($_POST['name']);
                $heure=htmlspecialchars($_POST['heure']);
                $lieu=htmlspecialchars($_POST['lieu']);
                $type=htmlspecialchars( $_POST['typeT']);
                $date=htmlspecialchars($_POST['date']);
                $jeu=htmlspecialchars($_POST['jeuT']);
                $Admin->createTournament($name, $cash, $type, $lieu, $heure, $date, $jeu);
                header('Location: ./index.php?page=accueil');
            }
            ob_start('createTournamentCodeReplace');
            require_once('./view/creertournoiview.html');
            ob_end_flush();
            break;
        case 'detailstournoi':
            require_once('./codereplacer/tournamentDetailsCodeReplace.php');
            require_once('./view/headerview.html');
            ob_start('tournamentDetailsCodeReplace');
            require_once('./view/detailstournoiview.html');
            ob_end_flush();
            break;
        default:
            require_once('./controller/Accueilcontroller.php');
            break;
    }
} else {
    require_once('./controller/Accueilcontroller.php');
}
?>