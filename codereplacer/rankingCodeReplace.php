<?php
function rankingCodeReplace($buffer)
{
    $codeToReplace = array('##printGameOptions##', '##printRankingTitle##', '##pathFormRanking##', '##printTeamRanking##');
    $listeJeux = Game::allGames();
    if (isset($_GET['jeuC']) && $_GET['jeuC']!= 'default') {
        $ranking = new Classement($_GET['jeuC']);
        $jeu = Game::getGameById($_GET['jeuC']);
        $teamRanking = $ranking->returnRanking();
    }
    $replacementCode = array('', '', '', '');
    $replacementCode[0] = "<option value='default'>--Choisissez un Jeu--</option>";
    foreach ($listeJeux as $jeu) {
        if (isset($_GET['jeuC']) && $_GET['jeuC'] == $jeu->getId()) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        $replacementCode[0] .= '<option value=' . $jeu->getId() . ' ' . $selected . '>' . $jeu->getName() . '</option>';
    }
    if (isset($_GET['jeuC']) && $_GET['jeuC']!= 'default') {
        $replacementCode[1] = '<h1>Classement du jeu : ' . Game::getGameById($_GET['jeuC'])->getName() . '</h1>';
    }
    $replacementCode[2] = './index.php?page=classement&jeuC=' . $_GET['jeuC'];

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
            $teamRankingTable .= '
            <tr>
            <td>' . $i++ . '</td>
            <td>' . $team->getName() . '</td>
            <td>' . $team->getPoints() . "</td>
            <td><a href='index.php?page=detailsequipe&IDE=" . $team->getId() . "'><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
            </tr>";
        }
        $replacementCode[3] = $teamRankingTable. '</tbody></table>
        </div>';
    }
    return (str_replace($codeToReplace, $replacementCode, $buffer));
}
?>