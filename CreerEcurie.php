﻿<?php
include './modele/Connexion.php';
include './modele/Administrateur.php';
session_start();
if(!isset($_SESSION["connexion"]))
{
    $singleton = Connexion::getInstance();
    $_SESSION['connexion'] = $singleton;
}
foreach ($_POST as $key => $value) {
    echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
}
$connx = $_SESSION['connexion'];
if(isset($_Post['submit'])){
    if($connx->getRole() == Role::Administrateur){
        foreach ($_POST as $key => $value) {
            echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
        }
        $Admin = new Administrateur();
        $Admin->creerEcurie($_Post['name'], $_Post['username'], $_Post['password'], $_Post['typeE']);
        foreach ($_POST as $key => $value) {
            echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css" />
    <title>E-Sporter Manager</title>
</head>
<body class="ecurie">
    <!--Menu de navigation-->
    <header>
        <div class="Menu">
            <div class="menunav">
            <nav class="navig">
                <a href="index.php">Home</a>
                <a href="ListeTournois.php">Liste des Tournois</a>
                <a href="Classement.html">Classement</a>
            </nav>
            <div class="menucenter">
                <img class="logo" src="/img/logo header.png">
            </div>
            </div>
            <div class="menuright">
                <div class="connecter">
                <?php 
                        if($connx->getRole() == Role::Visiteur){
                            echo '<a href="./ConnexionPage.php" id="connexion">Se Connecter</a>';
                        }else{
                            echo '<h3>Bonjour '.$connx->getRole().' '.$connx->getIdentifiant().'</h3>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="ecuriemain">
            <form action="CreerEcurie.php" id="formecurie" method="POST">
                <h1>Créer une écurie</h1>
                <div class="formulaire">
                    <label id="Eforml1"><b>Nom de l'écurie</b></label>
                    <input id="Eformi1" type="text" placeholder="Entrer le nom d'écurie" name="name" required>
                    <label id="Eforml2"><b>Nom du compte</b></label>
                    <input id="Eformi2" type="text" placeholder="Entrer l'identifiant" name="username" required>
                    <label id="Eforml3"><b>Mot de passe</b></label>
                    <input id="Eformi3" type="password" placeholder="Entrer le mot de passe" name="password" required>
                    <label id="Eforml4"><b>Type</b></label>
                    <select id="Eformt1" name="typeE">
                	    <option value="Professionnelle">Professionnelle</option>
                        <option value="Associative">Associative</option>
                    </select>
                    <input type="submit" class="buttonE" id="valider" value='VALIDER' >
                    <input type="submit" class="buttonE" id="annuler" value='ANNULER' onclick="history.back()" >
                </div>
            </form>
        </div>
    </main>
</body>
</html>