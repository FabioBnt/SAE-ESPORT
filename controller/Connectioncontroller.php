<?php
    function CreateTeamCodeReplace($buffer)
    {
        $codeToReplace = array("##ERROR CONNECTION##");
        $replacementCode = array("");
        if(isset($_GET['conn']) && $_GET['conn']==0){
            $result="<h1 style=\"width:100%;font-size:16px;color:red;text-align:center;\">Identifiant ou mot de passe incorrect</h1>";
        }  
        $replacementCode[0]=$result;
        return (str_replace($codeToReplace, $replacementCode, $buffer));
    }
    require('./view/connectionview.html');
    $connx = Connection::getInstance();
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $connx->establishConnection($_POST['username'], $_POST['password'], $_POST['roles']);
        if ($connx->getRole() == $_POST['roles']) {
            header("Location: ./index.php?page=accueil");
        } else {
            header("Location: ./index.php?page=connectionview&conn=0");
        }
    }
?>