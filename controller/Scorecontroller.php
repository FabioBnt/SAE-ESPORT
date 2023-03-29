<?php
$connx = Connection::getInstance();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'score':
            require_once('./codereplacer/scoreCodeReplace.php');
            require_once('./view/headerview.html');
            ob_start('scoreCodeReplace');
            require_once('./view/scoreview.html');
            ob_end_flush();
            break;
        case 'saisirscore':
            $listePools = null;
            if (isset($_GET['IDJ'])) {
                $listePools = $_SESSION['game' . $_GET['IDJ']];
            } else {
                $listePools = array();
            }
            if (isset($_GET['score1']) && isset($_GET['score2'])) {
                try {
                    MatchJ::setScore($listePools, $_GET['poule'], $_GET['equipe1'], $_GET['equipe2'], $_GET['score1'], $_GET['score2']);
                    exit();
                } catch (Exception $e) {
                    exit();
                }
            }
            break;
        default:
            require_once('./controller/Accueilcontroller.php');
            break;
    }
} else {
    require_once('./controller/Accueilcontroller.php');
}
?>