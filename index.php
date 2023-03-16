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
    $codeToReplace = array('##printCreateTournamentButton##', '##printCreateOrganizationButton##', '##printConnectionButton##', '##printHelloAndDisconnectButton##', '##printCreateTeamButton##', '##titleChange##');
    $replacementCode = array('', '', '', '', '', '');
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
    switch ($_GET['page']) {
        case 'accueil':
            $title = 'Accueil';
            break;
        case 'listetournoi':
            $title = 'Liste des tournois';
            break;
        case 'classement':
            $title = 'Classement';
            break;
        case 'creerecurie':
            $title = 'Créer une écurie';
            break;
        case 'creerequipe':
            $title = 'Créer une équipe';
            break;
        case 'creertournoi':
            $title = 'Créer un tournoi';
            break;
        case 'listeequipe':
            $title = 'Liste des équipes';
            break;
        case 'detailstournoi':
            $title = 'Détails du tournoi';
            break;
        case 'detailsequipe':
            $title = 'Détails de l\'équipe';
            break;
        case 'score':
            $title = 'Score';
            break;
        case 'saisirscore':
            $title = 'Saisie des scores';
            break;
        default:
            $title = 'Accueil';
            break;
    }
    $replacementCode[5]= $title ;
    return (str_replace($codeToReplace, $replacementCode, $buffer));
}
ob_start('headerCodeReplacer');
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