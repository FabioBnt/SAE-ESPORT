<?php
$connx = Connection::getInstance();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'creerequipe':
            function CreateTeamCodeReplace($buffer)
            {
                $connx = Connection::getInstance();
                $codeToReplace = array("##GameListTeam##");
                $replacementCode = array();
                $GameList="";
                if ($connx->getRole() == Role::Organization) {
                    $id = Organization::getIDbyAccountName($connx->getIdentifiant());
                }
                $listeJeux = Game::getGameTeamNotPlayed($id);  
                foreach($listeJeux as $jeu){ 
                    $GameList.="<option value=".$jeu->getId()."><".$jeu->getName()."</option>";
                }
                $replacementCode[0]=$GameList;
                return (str_replace($codeToReplace, $replacementCode, $buffer));
            }
            require('./view/headerview.html');
            ob_start("CreateTeamCodeReplace");
            require('./view/creerequipeview.html');
            ob_end_flush(); 
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
                            <td><a href=\"./index.php?page=detailsequipe&IDE=".$E->getId()."\"><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
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
                    <td><a href=\"./index.php?page=detailsequipe&IDE=".$E->getId()."\"><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
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
            function DetailsTeamCodeReplace($buffer)
            {
                $Tournament=new Tournament();
                $Equipes = new Team();
                $Equipe = $Equipes->getTeam($_GET['IDE']);
                $Joueurs = $Equipe->getPlayers($_GET['IDE']);
                $data=$Tournament->tournamentsParticipatedByTeam($_GET['IDE']);
                $codeToReplace = array("##GETNAMETEAM##","##GETGAMETEAM##","##GETORGATEAM##",
                "##GETTWINTEAM##","##GETGAINWINTEAM##","##GETPOINTSTEAM##","##GETPLAYERSTEAM##","##GETTOURNAMENTTEAM##");
                $replacementCode = array($Equipe->getName(),$Equipe->getGameName(),$Equipe->getOrganization(),$Equipe->getNbmatchWin(),
                $Equipe->sumTournamentWin(),$Equipe->getPoints(),"","");
                $Players="";
                if($data==null){
                    $i=0;
                    while($i<4){ 
                    $Players.="<tr>
                        <td><img class='imgB' src='./img/inconnu.png' alt='Rien'></td>
                        <td><img class='imgB' src='./img/inconnu.png' alt='Rien'></td>
                    </tr>";
                    $i++;
                    }
                }else{
                    $i=0;
                    foreach ($Joueurs as $J){
                        $Players.="<tr>
                        <td>".$J['Pseudo']."</td>
                        <td>".$J['Nationalite']."</td>
                        </tr>";
                        $i++;
                    }
                    while($i<4){
                        $Players.="<tr>
                            <td><img class='imgB' src='./img/inconnu.png' alt='Rien'></td>
                            <td><img class='imgB' src='./img/inconnu.png' alt='Rien'></td>
                        </tr>";
                        $i++;
                    }
                }
                $TournamentTeam="";
                if($data !=array()){
                    $TournamentTeam.="<table>
                    <thead>
                    <tr><th colspan='9'>Liste des Tournois Participés</th></tr>    
                    <tr>
                        <th>Nom</th>
                        <th>CashPrize</th>
                        <th>Notoriété</th>
                        <th>Lieu</th>
                        <th>Heure de début</th>
                        <th>Date</th>
                        <th>Fin Inscription</th>
                        <th>Jeu</th>
                        <th>Plus d'info</th>
                    </tr>
                    </thead>
                    <tbody>";
                    foreach ($data as $T){
                        $TournamentTeam.="<tr>
                        <td>".$T->getName()."</td>
                        <td>".$T->getCashPrize()."</td>
                        <td>".$T->getNotoriety()."</td>
                        <td>".$T->getLocation()."</td>
                        <td>".$T->getHourStart()."</td>
                        <td>".$T->getDate()."</td>
                        <td>".$T->getregisterDeadline()."</td>
                        <td>".$T->namesgames()."</td>
                        <td><a href='./index.php?page=detailstournoi&IDT=".$T->getIdTournament()."'><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
                        </tr>";
                    }
                    $TournamentTeam.="</tbody>
                    </table>";
                    }
                $replacementCode[6]=$Players;
                $replacementCode[7]=$TournamentTeam;
                return (str_replace($codeToReplace, $replacementCode, $buffer));
            }
            require('./view/headerview.html');
            ob_start("DetailsTeamCodeReplace");
            require('./view/detailsequipeview.html');
            ob_end_flush();
            break;
        default:
            require('./controller/Accueilcontroller.php');
            break;
    }
} else {
    require('./controller/Accueilcontroller.php');
}
?>