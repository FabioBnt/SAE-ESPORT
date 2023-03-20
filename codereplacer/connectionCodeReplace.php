<?php
function connectionCodeReplace($buffer)
{
    $codeToReplace = array('##ERROR CONNECTION##','##SelectedOrganization##','##SelectedTeam##',
    '##SelectedArbitre##','##SelectedAdministrator##');
    $replacementCode = array('','','','','');
    if(isset($_GET['conn']) && $_GET['conn']==0){
        $result="<h1 style=\"width:100%;font-size:16px;color:red;text-align:center;\">Identifiant ou mot de passe incorrect</h1>";
    }  
    $replacementCode[0]=$result;
    switch ($_COOKIE['role']) {
        case 'Organization':
            $replacementCode[1]='selected';
            break;
        case 'Team':
            $replacementCode[2]='selected';
            break;
        case 'Arbitre':
            $replacementCode[3]='selected';
            break;
        case 'Administrator':
            $replacementCode[4]='selected';
            break;                
    }
    return (str_replace($codeToReplace, $replacementCode, $buffer));
}
?>