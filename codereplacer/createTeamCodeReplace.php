<?php
function createTeamCodeReplace($buffer)
{
    $connx = Connection::getInstance();
    $codeToReplace = array('##GameListTeam##');
    $replacementCode = array();
    $GameList= '';
    if ($connx->getRole() == Role::Organization) {
        $id = Organization::getIDbyAccountName($connx->getIdentifiant());
    }
    $listeJeux = Game::getGameTeamNotPlayed($id);  
    foreach($listeJeux as $jeu){ 
        $GameList.= '<option value=' .$jeu->getId(). '>' .$jeu->getName(). '</option>';
    }
    $replacementCode[0]=$GameList;
    return (str_replace($codeToReplace, $replacementCode, $buffer));
}
?>