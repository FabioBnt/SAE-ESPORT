<?php
$connx = Connection::getInstance();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'creerequipe':
            require('./view/headerview.html');
            require('./view/creerequipeview.html');
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
            function teamCodeReplace($buffer)
            {
                $connx = Connection::getInstance();
                $Equipes = new Team();
                $codeToReplace = array("##FOREACHTEAMORGA##","##FOREACHTEAM##");
                $replacementCode = array("","");
                $Orgalist = "";
                $Teamlist="";
                if($connx->getRole() == Role::Organization){
                    $Orgalist.= "<a href='./index.php?page=creerequipe' class='buttonE'>Créer Equipe</a>
                    </div><h1>Mes équipes</h1><div>
                        <table id='TabEquipe'>
                    <thead><tr><th >Nom</th><th >Jeu</th><th >Plus dinformations</th></tr></thead>
                    <tbody>";
                    $identifiant = $connx->getIdentifiant();
                    $id = Organization::getIDbyAccountName($identifiant);
                    $listeE = $Equipes->getTeamList($id);
                    foreach ($listeE as $E){
                        $Orgalist.="<tr>
                            <td>".$E->getName()."</td>
                            <td>".$E->getGameName()."</td>
                            <td><a href=\"./index.php?page=detailsequipe&IDE=".$E->getId()."><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
                        </tr>";
                    }
                    $Orgalist.="</tbody></table></div>";
                }
                $listeE2= $Equipes->getTeamList();
                foreach ($listeE2 as $E){ 
                    $Teamlist.="<tr>
                    <td>".$E->getName().
                    "</td><td>".$E->getOrganization()."</td>
                    <td>".$E->getGameName()."</td>
                    <td><a href=\"./index.php?page=detailsequipe&IDE=".$E->getId()."><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
                    </tr>";
                }
                $replacementCode[0] = $Orgalist;
                $replacementCode[1] = $Teamlist;
            return (str_replace($codeToReplace, $replacementCode, $buffer));
            }
            require('./view/headerview.html');
            ob_start("teamCodeReplace");
            require('./view/listeequipeview.html');
            ob_end_flush();
            break;
        case 'detailsequipe':
            require('./view/headerview.html');
            $Equipe = $Equipes->getTeam($_GET['IDE']);
            $Joueurs = $Equipe->getPlayers($_GET['IDE']);
            $data=$Tournament->tournamentsParticipatedByTeam($_GET['IDE']);
            require('./view/detailsequipeview.html');
            break;
        default:
            require('./controller/Accueilcontroller.php');
            break;
    }
} else {
    require('./controller/Accueilcontroller.php');
}
?>