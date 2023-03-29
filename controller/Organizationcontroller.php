<?php
require_once('./view/headerview.html');
$connx = Connection::getInstance();
//if we are not connected as admin then we are redirected to the home page
if ($connx->getRole() != Role::Administrator) {
    header('Location: ./index.php?page=accueil');
}
if (isset($_POST['submit'])) {
    $name=htmlspecialchars($_POST['name']);
    $username=htmlspecialchars($_POST['username']);
    $password=htmlspecialchars($_POST['password']);
    $type=htmlspecialchars( $_POST['typeE']);
    $Admin->createOrganization($name, $username, $password, $type);
    header('Location: ./index.php?page=accueil');
}
require_once('./view/createorganizationview.html');
?>