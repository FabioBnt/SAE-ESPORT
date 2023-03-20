<?php
    function ConnectionCodeReplace($buffer)
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
    ob_start('ConnectionCodeReplace');
    require_once('./view/connectionview.html');
    ob_end_flush();
    $connx = Connection::getInstance();
    if (isset($_POST['username']) && isset($_POST['password'])) {
        setcookie( 'role', $_POST['roles'], time() + 3600 );
        $connx->establishConnection($_POST['username'], $_POST['password'], $_POST['roles']);
        if ($connx->getRole() == $_POST['roles']) {
            header('Location: ./index.php?page=accueil');
        } else {
            header('Location: ./index.php?page=connectionview&conn=0');
        }
    }
?>