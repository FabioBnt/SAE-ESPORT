<?php
include './modele/Tournois.php';
//print errors when opening page
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$listeTournois = new Tournois();

$listeTournois->tousLesTournois();

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
<body class="tournois">
    <!--Menu de navigation-->
    <header>
        <div class="Menu">
            <div class="menunav">
            <nav class="navig">
                <a href="./index.html">Home</a>
                <a href="./ListeTournois.html">Liste des Tournois</a>
                <a href="./Classement.html">Classement</a>
            </nav>
            <div class="menucenter">
                <img class="logo" src="./img/logo header.png">
            </div>
            </div>
            <div class="menuright">
                <div class="connecter">
                    <a href="./Connexion.html" id="connexion">Se Connecter</a>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="tournoismain">
            <h1>Liste des Tournois</h1>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>CashPrize</th>
                            <th>Notoriété</th>
                            <th>Lieu</th>
                            <th>Heure de début</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php $listeTournois->afficherTournois() ?>
                            <td><a href="./DetailsTournoi.html">+</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>