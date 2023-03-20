<?php
function detailsTeamCodeReplace($buffer)
{
    $Tournament=new Tournament();
    $Equipes = new Team();
    $Equipe = $Equipes->getTeam($_GET['IDE']);
    $Joueurs = $Equipe->getPlayers($_GET['IDE']);
    $data=$Tournament->tournamentsParticipatedByTeam($_GET['IDE']);
    $codeToReplace = array('##GETNAMETEAM##', '##GETGAMETEAM##', '##GETORGATEAM##',
        '##GETTWINTEAM##', '##GETGAINWINTEAM##', '##GETPOINTSTEAM##', '##GETPLAYERSTEAM##', '##GETTOURNAMENTTEAM##');
    $replacementCode = array($Equipe->getName(),$Equipe->getGameName(),$Equipe->getOrganization(),$Equipe->getNbmatchWin(),
    $Equipe->sumTournamentWin(),$Equipe->getPoints(), '', '');
    $Players= '';
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
            $Players.= '<tr>
            <td>' .$J['Pseudo']. '</td>
            <td>' .$J['Nationalite']. '</td>
            </tr>';
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
    $TournamentTeam= '';
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
            $TournamentTeam.= '<tr>
            <td>' .$T->getName(). '</td>
            <td>' .$T->getCashPrize(). '</td>
            <td>' .$T->getNotoriety(). '</td>
            <td>' .$T->getLocation(). '</td>
            <td>' .$T->getHourStart(). '</td>
            <td>' .$T->getDate(). '</td>
            <td>' .$T->getregisterDeadline(). '</td>
            <td>' .$T->namesgames()."</td>
            <td><a href='./index.php?page=detailstournoi&IDT=".$T->getIdTournament()."'><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
            </tr>";
        }
        $TournamentTeam.= '</tbody>
        </table>';
        }
    $replacementCode[6]=$Players;
    $replacementCode[7]=$TournamentTeam;
    return (str_replace($codeToReplace, $replacementCode, $buffer));
}
?>