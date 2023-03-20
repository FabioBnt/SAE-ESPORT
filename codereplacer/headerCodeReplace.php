<?php
function headerCodeReplace($buffer)
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
    $replacementCode[5] = $title;
    return (str_replace($codeToReplace, $replacementCode, $buffer));
}
?>