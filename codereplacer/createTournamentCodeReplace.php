<?php
function createTournamentCodeReplace($buffer)
{
    $codeToReplace = array('##GameListTournament##', '##DATETournament##');
    $replacementCode = array();
    $listeJeux = Game::allGames();
    $date = date('Y-m-d', strtotime('+1 month'));
    foreach ($listeJeux as $jeu) {
        $result.= "<div><input type=\"checkbox\" name=\"jeuT[]\" value=" . $jeu->getId() . '>' . $jeu->getName() . '</div>';
    }
    $dateT = "<input id=\"Tformi2\" type=\"date\" name=\"date\" min=".$date. ' value=' .$date. ' require_onced>';
    $replacementCode[0] = $result;
    $replacementCode[1] = $dateT;
    return (str_replace($codeToReplace, $replacementCode, $buffer));
}
?>