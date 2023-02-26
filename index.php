<!--Contrôleur-->
<!--parametre "page" pour recup qu'elle page on est-->
<?php
require_once('./model/Connection.php');
require_once('./model/Administrator.php');
require_once('./model/Game.php');
require_once('./model/Role.php');
require_once('./model/Organization.php');
require_once('./model/Tournament.php');
require_once('./model/Team.php');
require_once('./model/Classement.php');
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
            require('./controller/Accueilcontroller.php');
            break;
        case 'connectionview':
            require("./controller/Connectioncontroller.php");
            break;
        case 'listetournoi':
            require("./controller/Tournamentcontroller.php");
            break;
        case 'classement':
            require("./controller/Tournamentcontroller.php");
            break;
        case 'creerecurie':
            require("./controller/Organizationcontroller.php");
            break;
        case 'creerequipe':
            require("./controller/Teamcontroller.php");
            break;
        case 'creertournoi':
            require("./controller/Tournamentcontroller.php");
            break;
        case 'listeequipe':
            require("./controller/Teamcontroller.php");
            break;
        case 'detailstournoi':
            require("./controller/Tournamentcontroller.php");
            break;
        case 'detailsequipe':
            require("./controller/Teamcontroller.php");
            break;
        case 'score':
            require("./controller/Scorecontroller.php");
            break;
        case 'saisirscore':
            require("./controller/Scorecontroller.php");
            break;
        default:
            require('./controller/Accueilcontroller.php');
            break;
    }
} else {
    require('./controller/Accueilcontroller.php');
}
?>