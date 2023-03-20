<?php
function tournamentDetailsCodeReplace($buffer)
{
    $connx = Connection::getInstance();
    $idTournament = null;
    if (isset($_GET['IDT'])) {
        $idTournament = $_GET['IDT'];
    } else {
        header('Location: ./index.php?page=listetournoi');
        exit();
    }
    if (isset($_GET['IDJ'])) {
        header('Location:./index.php?page=score&IDJ=' . $_GET['IDJ'] . '&NomT=' . $_GET['NomT'] . '&JeuT=' . $_GET['JeuT'] . '&valide');
        exit();
    }
    $Tournament = new Tournament();
    $Tournament->allTournaments();
    $tournament = $Tournament->getTournament($idTournament);
    $PoolsGame = $tournament->getPools();
    
    if (isset($_GET['inscrire'])) {
        $idEquipe = $_GET['inscrire'];
        $equipe = Team::getTeam($idEquipe);
        try {
            $equipe->register($tournament);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    

    $codeToReplace = array('##GETNAMETOURNAMENT##', '##GETDATETOURNAMENT##', '##GETHOURTOURNAMENT##',
        '##GETLOCATIONTOURNAMENT##', '##GETCASHPRIZETOURNAMENT##', '##GETNOTORIETYTOURNAMENT##', '##GETGAMESTOURNAMENT##',
        '##GETREGISTERTOURNAMENT##', '##GETPARTICIPANTTOURNAMENT##');
    $replacementCode = array('', '', '', '', '', '', '', '', '');

    $replacementCode[0] = $tournament->getName();
    $replacementCode[1] = $tournament->getDate();
    $replacementCode[2] = $tournament->getHourStart();
    $replacementCode[3] = $tournament->getLocation();
    $replacementCode[4] = $tournament->getCashPrize();
    $replacementCode[5] = $tournament->getNotoriety();

    $gameTable = '';
    foreach ($tournament->getGames() as $jeu) {
        $gameTable .= '<tr>
        <td>' . $jeu->getName() . '</td>
        <td>' . $jeu->getDateLimit($tournament->getdateHour()) . "</td>
        <td><a href='./index.php?page=score&IDJ=" . $jeu->getId() . '&NomT=' . $tournament->getName() . '&JeuT=' . $jeu->getName() . "'><img src='./img/Detail.png' alt='Details' class='imgB'></a></td>
        </tr>";
        // modified PoolsJeux by poolJeux[id];
        $_SESSION['game' . $jeu->getId()] = $PoolsGame[$jeu->getId()];
    }
    $replacementCode[6] = $gameTable;

    $nomCompteEquipe = $connx->getIdentifiant();
    if ($connx->getRole() == Role::Team) {
        $idEquipe = Team::getTeamIDByAccountName($nomCompteEquipe);
        $equipe = Team::getTeam($idEquipe);
    }

    if (!isset($_GET['inscrire'])) {
        if ($connx->getRole() == Role::Team) {
            if ($tournament->haveGame($equipe->getGameId())) { 
                $replacementCode[7] = "<button class='buttonE' id='Dgrida1' onclick=\"confirmerInscription($idTournament,$idEquipe)\">S'inscrire</button>";
            } 
        }
    }
    
    $participantTable = '';
    foreach($tournament->getGames() as $jeu){
        $teampools=$tournament->TeamsOfPoolParticipants($jeu->getId());
        if ($teampools != array()) {
            $participantTable .= "<table>
            <thead>
                <tr><th colspan='2'>".$jeu->getName(). '</th></tr>
                <tr>
                    <th>Participant</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($teampools as $participant) {
                $participantTable .= '<tr>
                <td>' . $participant->getName() . "</td>
                <td><a href='./index.php?page=detailsequipe&IDE=" . $participant->getId() . "'><img class='imgB' src='./img/detail.png' alt='Details'></a></td>
                </tr>";
            }
            $participantTable .= '</tbody>
            </table>';
        }
    }
    $replacementCode[8] = $participantTable;
    return (str_replace($codeToReplace, $replacementCode, $buffer));
}
?>