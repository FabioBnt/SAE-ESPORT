<?php
require('./view/headerview.html');
$connx = Connection::getInstance();

//if we are not connected as admin then we are redirected to the home page
if ($connx->getRole() != Role::Administrator) {
    header('Location: ./index.php?page=accueil');
}
if (isset($_POST['submit'])) {
    $Admin->createOrganization($_POST['name'], $_POST['username'], $_POST['password'], $_POST['typeE']);
    header('Location: ./index.php?page=accueil');
}
require('./view/creerecurieview.html');
?>