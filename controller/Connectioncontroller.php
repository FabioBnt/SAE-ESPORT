<?
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'connectionview':
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $connx->establishConnection($_POST['username'], $_POST['password'], $_POST['roles']);
                if ($connx->getRole() == $_POST['roles']) {
                    header("Location: ./index.php?page=accueil");
                } else {
                    header("Location: ./index.php?page=connectionview&conn=0");
                }
            }
            require('./view/connectionview.php');
        default:
            require('./controller/Accueilcontroller.php');
            break;
    }
} else {
    require('./controller/Accueilcontroller.php');
}
?>