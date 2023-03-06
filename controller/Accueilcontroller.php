<?php
function homeCodeReplace($buffer)
{
    $connx = Connection::getInstance();
    $codeToReplace = array("##printCreateTournamentButton##", "##printCreateOrganizationButton##");
    $replacementCode = array("","");
    if($connx->getRole()==Role::Administrator){
        $replacementCode[0] = "<button class=\"buttonM\" onclick=\"window.location.href='./index.php?page=creertournoi'\">Créer Tournoi</button>";
    } 
    if($connx->getRole()==Role::Administrator){
        $replacementCode[1] = "<button class=\"buttonM\" onclick=\"window.location.href='./index.php?page=creerecurie'\">Créer Ecurie</button>";
    }
    return (str_replace($codeToReplace, $replacementCode, $buffer));
}
$connx = Connection::getInstance();
require('./view/headerview.html');
ob_start("homeCodeReplace");
require('./view/accueilview.html');
ob_end_flush();
?>