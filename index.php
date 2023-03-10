<!-- Main Controller-->
<!-- page parameter to know where we have to go -->
<?php
require_once('./model/Connection.php');
require_once('./model/Administrator.php');
require_once('./model/Game.php');
require_once('./model/Role.php');
require_once('./model/Organization.php');
require_once('./model/Tournament.php');
require_once('./model/Team.php');
require_once('./model/Classement.php');

function headerCodeReplacer($buffer)
{
    $connx = Connection::getInstance();
    $codeToReplace = array("##printCreateTournamentButton##", "##printCreateOrganizationButton##", "##printConnectionButton##", "##printHelloAndDisconnectButton##", "##printCreateTeamButton##");
    $replacementCode = array("", "", "", "", "");
    if ($connx->getRole() == Role::Administrator) {
        $replacementCode[0] = "<button class=\"buttonM\" onclick=\"window.location.href='./index.php?page=creertournoi'\">Créer Tournoi</button>";
        $replacementCode[1] = "<button class=\"buttonM\" onclick=\"window.location.href='./index.php?page=creerecurie'\">Créer Ecurie</button>";
    }
    if ($connx->getRole() == Role::Organization) {
        $replacementCode[4] = "<button class=\"buttonM\" onclick=\"window.location.href='./index.php?page=creerequipe'\">Créer Equipe</button>";
    }
    if ($connx->getRole() == Role::Visiteur) {
        $replacementCode[2] = "<a href=\"./index.php?page=connectionview\" id=\"Connection\">Se Connecter</a>";
    } else if ($connx->getRole() != Role::Visiteur) {
        $replacementCode[3] = "<h3 style=\"padding:0.6em;\">Bienvenue - " . $connx->getIdentifiant() . "</h3><a href=\"./index.php?page=accueil&sedeconnecter=true\" id=\"deconnexion\">Déconnexion</a>";
    }
    return (str_replace($codeToReplace, $replacementCode, $buffer));
}
ob_start("headerCodeReplacer");
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
ob_end_flush();
?>