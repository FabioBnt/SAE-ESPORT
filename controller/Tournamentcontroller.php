<?php
$connx = Connection::getInstance();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'listetournoi':
            function tournamentCodeReplacer($buffer)
            {
                $Tournament = new Tournament();
                $codeToReplace = array("##FOREACH TOURNAMENT##");
                $replacementCode = array("");
                $liste = $Tournament->allTournaments();
                if (
                    isset($_GET['jeu']) || isset($_GET['nom']) || isset($_GET['prixmin']) || isset($_GET['prixmax'])
                    || isset($_GET['Notoriety']) || isset($_GET['lieu']) || isset($_GET['date'])
                ) {
                    // if not empty value of the input else null
                    $jeu = !empty($_GET['jeu']) ? $_GET['jeu'] : null;
                    $nom = !empty($_GET['nom']) ? $_GET['nom'] : null;
                    $prixmin = !empty($_GET['prixmin']) ? $_GET['prixmin'] : null;
                    $prixmax = !empty($_GET['prixmax']) ? $_GET['prixmax'] : null;
                    $notoriety = !empty($_GET['Notoriety']) ? $_GET['Notoriety'] : null;
                    $lieu = !empty($_GET['lieu']) ? $_GET['lieu'] : null;
                    $date = !empty($_GET['date']) ? $_GET['date'] : null;
                    try {
                        $liste = $Tournament->tournamentsFilter($jeu, $nom, $prixmin, $prixmax, $notoriety, $lieu, $date);
                    } catch (Exception $e) {
                        $e->getMessage(); // to verify
                    }
                }
                $tournamentList = "";
                foreach ($liste as $T) {
                    $tournamentList .= "<tr>
                        <td>" . $T->getName() . "</td>
                        <td> " . $T->getCashPrize() . "</td>
                        <td> " . $T->getNotoriety() . "</td>
                        <td> " . $T->getLocation() . "</td>
                        <td> " . $T->getHourStart() . "</td>
                        <td> " . $T->getDate() . "</td>
                        <td> " . $T->getregisterDeadline() . "</td>
                        <td> " . $T->namesgames() . "</td>
                        <td><a href=\"./index.php?page=detailstournoi&IDT=".$T->getIdTournament()."\"><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
                        </tr>";
                }
                $replacementCode[0] = $tournamentList;
                return (str_replace($codeToReplace, $replacementCode, $buffer));
            }
            require_once('./view/headerview.html');
            ob_start("tournamentCodeReplacer");
            require_once('./view/listetournoisview.html');
            ob_end_flush();
            break;
        case 'classement':
            function rankingCodeReplacer($buffer)
            {
                $codeToReplace = array("##printGameOptions##", "##printRankingTitle##", "##pathFormRanking##", "##printTeamRanking##");
                $listeJeux = Game::allGames();
                if (isset($_GET['jeuC']) && $_GET['jeuC']!="default") {
                    $ranking = new Classement($_GET['jeuC']);
                    $jeu = Game::getGameById($_GET['jeuC']);
                    $teamRanking = $ranking->returnRanking();
                }
                $replacementCode = array("","","","");
                $replacementCode[0] = "<option value='default'>--Choisissez un Jeu--</option>";
                foreach ($listeJeux as $jeu) {
                    if (isset($_GET['jeuC']) && $_GET['jeuC'] == $jeu->getId()) {
                        $selected = "selected";
                    } else {
                        $selected = "";
                    }
                    $replacementCode[0] .= "<option value=" . $jeu->getId() . " " . $selected . ">" . $jeu->getName() . "</option>";
                }
                if (isset($_GET['jeuC']) && $_GET['jeuC']!="default") {
                    $replacementCode[1] = "<h1>Classement du jeu : " . Game::getGameById($_GET['jeuC'])->getName() . "</h1>";
                }
                $replacementCode[2] = "./index.php?page=classement&jeuC=" . $_GET['jeuC'];

                if (!empty($teamRanking)) {
                    $i = 1;
                    $teamRankingTable = "<div>
                    <table><thead><tr>
                    <th>Place</th>
                    <th>Nom</th>
                    <th>Nb de Points</th>
                    <th>Plus d'informations</th></tr>
                    </thead><tbody>";
                    foreach ($teamRanking as $team) {
                        $teamRankingTable .="
                        <tr>
                        <td>" . $i++ . "</td>
                        <td>" . $team->getname() . "</td>
                        <td>" . $team->getPoints() . "</td>
                        <td><a href='index.php?page=detailsequipe&IDE=" . $team->getId() . "'><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
                        </tr>";
                    }
                    $replacementCode[3] = $teamRankingTable."</tbody></table>
                    </div>";
                }
                return (str_replace($codeToReplace, $replacementCode, $buffer));
            }
            require_once('./view/headerview.html');
            ob_start("rankingCodeReplacer");
            require_once('./view/classementview.html');
            ob_end_flush();
            break;
        case 'creertournoi':
            function CreateTournamentCodeReplace($buffer)
            {
                $codeToReplace = array("##GameListTournament##", "##DATETournament##");
                $replacementCode = array();
                $listeJeux = Game::allGames();
                $date = date('Y-m-d', strtotime('+1 month'));
                foreach ($listeJeux as $jeu) {
                    $result.= "<div><input type=\"checkbox\" name=\"jeuT[]\" value=" . $jeu->getId() . ">" . $jeu->getName() . "</div>";
                }
                $dateT = "<input id=\"Tformi2\" type=\"date\" name=\"date\" min=".$date." value=".$date." require_onced>";
                $replacementCode[0] = $result;
                $replacementCode[1] = $dateT;
                return (str_replace($codeToReplace, $replacementCode, $buffer));
            }
            require_once('./view/headerview.html');
            //Checks if the user is connected and if he is an admin
            if ($connx == null || $connx->getRole() != Role::Administrator) {
                header('Location: ./index.php?page=accueil');
            }
            if (isset($_POST['submit'])) {
                $cash = $_POST['cashprize'];
                if ($cash < 0) {
                    $cash = 0;
                }
                $Admin->createTournament($_POST['name'], $cash, $_POST['typeT'], $_POST['lieu'], $_POST['heure'], $_POST['date'], $_POST['jeuT']);
                header('Location: ./index.php?page=accueil');
            }
            ob_start("CreateTournamentCodeReplace");
            require_once('./view/creertournoiview.html');
            ob_end_flush();
            break;
        case 'detailstournoi':
            function TournamentDetailsCodeReplace($buffer)
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
                

                $codeToReplace = array("##GETNAMETOURNAMENT##","##GETDATETOURNAMENT##","##GETHOURTOURNAMENT##",
                "##GETLOCATIONTOURNAMENT##","##GETCASHPRIZETOURNAMENT##","##GETNOTORIETYTOURNAMENT##","##GETGAMESTOURNAMENT##",
                "##GETREGISTERTOURNAMENT##","##GETPARTICIPANTTOURNAMENT##");
                $replacementCode = array("","","","","","","","","");

                $replacementCode[0] = $tournament->getName();
                $replacementCode[1] = $tournament->getDate();
                $replacementCode[2] = $tournament->getHourStart();
                $replacementCode[3] = $tournament->getLocation();
                $replacementCode[4] = $tournament->getCashPrize();
                $replacementCode[5] = $tournament->getNotoriety();

                $gameTable = "";
                foreach ($tournament->getGames() as $jeu) {
                    $gameTable .= "<tr>
                    <td>" . $jeu->getName() . "</td>
                    <td>" . $jeu->getdateLimit($tournament->getdateHour()) . "</td>
                    <td><a href='./index.php?page=score&IDJ=" . $jeu->getId() . "&NomT=" . $tournament->getName() . "&JeuT=" . $jeu->getName() . "'><img src='./img/Detail.png' alt='Details' class='imgB'></a></td>
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
                
                $participantTable = "";
                foreach($tournament->getGames() as $jeu){
                    $teampools=$tournament->TeamsOfPoolParticipants($jeu->getId());
                    if ($teampools != array()) {
                        $participantTable .= "<table>
                        <thead>
                            <tr><th colspan='2'>".$jeu->getName()."</th></tr>
                            <tr>
                                <th>Participant</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>";
                        foreach ($teampools as $participant) {
                            $participantTable .= "<tr>
                            <td>" . $participant->getName() . "</td>
                            <td><a href='./index.php?page=detailsequipe&IDE=" . $participant->getId() . "'><img class='imgB' src='./img/detail.png' alt='Details'></a></td>
                            </tr>";
                        }
                        $participantTable .= "</tbody>
                        </table>";
                    }
                }
                $replacementCode[8] = $participantTable;
                return (str_replace($codeToReplace, $replacementCode, $buffer));
            }


            require_once('./view/headerview.html');
            ob_start("TournamentDetailsCodeReplace");
            require_once('./view/detailstournoiview.html');
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