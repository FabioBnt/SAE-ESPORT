<?php
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