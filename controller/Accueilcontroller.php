<?php
function homeCodeReplace($buffer)
{
    $connx = Connection::getInstance();
    $codeToReplace = array("##printCreateTournamentButton##", "##printCreateOrganizationButton##","##printSuggestedTournamentsForTeam##");
    $replacementCode = array("","","");
    if($connx->getRole()==Role::Administrator){
        $replacementCode[0] = "<button class=\"buttonM\" onclick=\"window.location.href='./index.php?page=creertournoi'\">Créer Tournoi</button>";
    } 
    if($connx->getRole()==Role::Administrator){
        $replacementCode[1] = "<button class=\"buttonM\" onclick=\"window.location.href='./index.php?page=creerecurie'\">Créer Ecurie</button>";
    }
    if($connx->getRole()==Role::Team){
        $tournament = new Tournament();
        $teamName = $connx->getIdentifiant();
        $idTeam=Team::getIDbyname($teamName);
        $team = Team::getTeam($idTeam);
        $listTournaments = $tournament->tournamentsSuggestedByTeam($team->getId(),$team->getgameId());
        $teamTournaments = "<table>
        <thead>
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
        foreach ($listTournaments as $T){
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
        $replacementCode[2] = $teamTournaments."</tbody>
        </table>";;
    }
    return (str_replace($codeToReplace, $replacementCode, $buffer));
}
$connx = Connection::getInstance();
require('./view/headerview.html');
ob_start("homeCodeReplace");
require('./view/accueilview.html');
ob_end_flush();
?>