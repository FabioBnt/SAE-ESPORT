<?
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'creerequipe':
            require('./view/headerview.php');
            require('./view/creerequipeview.php');
            if ($connx->getRole() == Role::Organization) {
                $id = Organization::getIDbyAccountName($connx->getIdentifiant());
            }
            $listeJeux = Game::getGameTeamNotPlayed($id);   
            if (isset($_POST['submit'])) {
                if ($connx->getRole() == Role::Organization) {
                    $Organization = Organization::getOrganization($id);
                    $Organization->createTeam($_POST['name'], $_POST['username'], $_POST['password'], $_POST['jeuE'], Organization::getIDbyAccountName($connx->getIdentifiant()));
                    $IdEquipe = Team::getIDbyname($_POST['name']);
                    for($i=0;$i<4;$i++){
                        if (!empty($_POST['pseudo'.$i])) {
                            $Organization->createPlayer($_POST['pseudo'.$i], $_POST['nat'.$i], $IdEquipe);}
                    }
                }
            }
            break;
        case 'listeequipe':
            require('./view/headerview.php');
            $identifiant = $connx->getIdentifiant();
            if ($connx->getRole() == Role::Organization) {
                $id = Organization::getIDbyAccountName($identifiant);
                $listeE = $Equipes->getTeamList($id);
            }
            $listeE2 = $Equipes->getTeamList();
            require('./view/listeequipeview.php');
            break;
        case 'detailsequipe':
            require('./view/headerview.php');
            $Equipe = $Equipes->getTeam($_GET['IDE']);
            $Joueurs = $Equipe->getPlayers($_GET['IDE']);
            $data=$Tournament->tournamentsParticipatedByTeam($_GET['IDE']);
            require('./view/detailsequipeview.php');
            break;
        default:
            require('./controller/Accueilcontroller.php');
            break;
    }
} else {
    require('./controller/Accueilcontroller.php');
}
?>