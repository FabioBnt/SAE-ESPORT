<?php
$connx = Connection::getInstance();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'creerequipe':
            //if we are not connected as admin then we are redirected to the home page
            if ($connx->getRole() != Role::Organization) {
                header('Location: ./index.php?page=accueil');
            }
            require_once('./codereplacer/createTeamCodeReplace.php');
            require_once('./view/headerview.html');
            ob_start('createTeamCodeReplace');
            require_once('./view/createteamview.html');
            ob_end_flush(); 
            if (isset($_POST['submit'])) {
                if ($connx->getRole() == Role::Organization) {
                    $id = Organization::getIDbyAccountName($connx->getIdentifiant());
                    $Organization = Organization::getOrganization($id);
                    $name=htmlspecialchars($_POST['name']);
                    $username=htmlspecialchars($_POST['username']);
                    $password=htmlspecialchars($_POST['password']);
                    $jeu=htmlspecialchars( $_POST['jeuE']);
                    $Organization->createTeam($name,$username, $password, $jeu,$id);
                    $IdEquipe = Team::getIDbyName($name);
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
            require_once('./view/teamlistview.html');
            ob_end_flush();
            break;
        case 'detailsequipe':
            require_once('./codereplacer/detailsTeamCodeReplace.php');
            require_once('./view/headerview.html');
            ob_start('detailsTeamCodeReplace');
            require_once('./view/detailsteamview.html');
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