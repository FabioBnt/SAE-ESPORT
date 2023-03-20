<?php
    require_once("./codereplacer/connectionCodeReplace.php");
    ob_start('connectionCodeReplace');
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