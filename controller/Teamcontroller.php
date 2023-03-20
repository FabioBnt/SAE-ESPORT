<?php
$connx = Connection::getInstance();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'creerequipe':
            require_once('./codereplacer/createTeamCodeReplace.php');
            require_once('./view/headerview.html');
            ob_start('createTeamCodeReplace');
            require_once('./view/creerequipeview.html');
            ob_end_flush(); 
            if (isset($_POST['submit'])) {
                if ($connx->getRole() == Role::Organization) {
                    $id = Organization::getIDbyAccountName($connx->getIdentifiant());
                    $Organization = Organization::getOrganization($id);
                    $Organization->createTeam($_POST['name'],$_POST['username'], $_POST['password'], $_POST['jeuE'],$id);
                    $IdEquipe = Team::getIDbyName($_POST['name']);
                    for($i=0;$i<4;$i++){
                        if (!empty($_POST['pseudo'.$i])) {
                            $Organization->createPlayer($_POST['pseudo'.$i], $_POST['nat'.$i], $IdEquipe);}
                    }
                    header('Location: ./index.php?page=accueil');
                }
            }
            break;
        case 'listeequipe':
            require_once('./codereplacer/teamCodeReplace.php');
            require_once('./view/headerview.html');
            ob_start('teamCodeReplace');
            require_once('./view/listeequipeview.html');
            ob_end_flush();
            break;
        case 'detailsequipe':
            require_once('./codereplacer/detailsTeamCodeReplace.php');
            require_once('./view/headerview.html');
            ob_start('detailsTeamCodeReplace');
            require_once('./view/detailsequipeview.html');
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