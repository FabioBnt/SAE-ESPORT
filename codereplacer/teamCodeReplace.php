<?php
function teamCodeReplace($buffer)
{
    $connx = Connection::getInstance();
    $Equipes = new Team();
    $codeToReplace = array('##FOREACHTEAMORGA##', '##FOREACHTEAM##');
    $replacementCode = array('', '');
    $Orgalist = '';
    $Teamlist= '';
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
            $Orgalist.= '<tr>
                <td>' .$E->getName(). '</td>
                <td>' .$E->getGameName()."</td>
                <td><a href=\"./index.php?page=detailsequipe&IDE=".$E->getId()."\"><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
            </tr>";
        }
        $Orgalist.= '</tbody></table></div>';
    }
    $listeE2= $Equipes->getTeamList();
    foreach ($listeE2 as $E){ 
        $Teamlist.= '<tr>
        <td>' .$E->getName().
            '</td><td>' .$E->getOrganization(). '</td>
        <td>' .$E->getGameName()."</td>
        <td><a href=\"./index.php?page=detailsequipe&IDE=".$E->getId()."\"><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
        </tr>";
    }
    $replacementCode[0] = $Orgalist;
    $replacementCode[1] = $Teamlist;
return (str_replace($codeToReplace, $replacementCode, $buffer));
}
?>