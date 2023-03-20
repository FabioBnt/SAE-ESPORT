<!-- Main Controller-->
<!-- page parameter to know where we have to go -->
<?php
require_once('./model/Connection.php');
require_once('./model/Administrator.php');
require_once('./model/Game.php');
require_once('./model/Role.php');
require_once('./model/Organization.php');
require_once('./model/Pool.php');
require_once('./model/MatchJ.php');
require_once('./model/Tournament.php');
require_once('./model/Team.php');
require_once('./model/Classement.php');
require_once('./codereplacer/headerCodeReplace.ph');
ob_start('headerCodeReplace');
$Admin = new Administrator();
$connx = Connection::getInstance();
$Tournament = new Tournament();
$Equipes = new Team();
if (isset($_GET['sedeconnecter'])) {
    $connx->disconnect();
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'accueil':
            require_once('./controller/Accueilcontroller.php');
            break;
        case 'connectionview':
            require_once('./controller/Connectioncontroller.php');
            break;
        case 'listetournoi':
            require_once('./controller/Tournamentcontroller.php');
            break;
        case 'classement':
            require_once('./controller/Tournamentcontroller.php');
            break;
        case 'creerecurie':
            require_once('./controller/Organizationcontroller.php');
            break;
        case 'creerequipe':
            require_once('./controller/Teamcontroller.php');
            break;
        case 'creertournoi':
            require_once('./controller/Tournamentcontroller.php');
            break;
        case 'listeequipe':
            require_once('./controller/Teamcontroller.php');
            break;
        case 'detailstournoi':
            require_once('./controller/Tournamentcontroller.php');
            break;
        case 'detailsequipe':
            require_once('./controller/Teamcontroller.php');
            break;
        case 'score':
            require_once('./controller/Scorecontroller.php');
            break;
        case 'saisirscore':
            require_once('./controller/Scorecontroller.php');
            break;
        default:
            require_once('./controller/Accueilcontroller.php');
            break;
    }
} else {
    require_once('./controller/Accueilcontroller.php');
}
ob_end_flush();
?>