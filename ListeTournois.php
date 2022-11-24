<?php
include './modele/Connexion.php';
include './modele/Tournois.php';
session_start();
if(!isset($_SESSION["connexion"]))
{
    $singleton = Connexion::getInstance();
    $_SESSION['connexion'] = $singleton;
}
$connx = $_SESSION['connexion'];
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
                <a href="./index.php">Home</a>
                <a href="./ListeTournois.html">Liste des Tournois</a>
                <a href="./Classement.html">Classement</a>
            </nav>
            <div class="menucenter">
                <img class="logo" src="./img/logo header.png">
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
                            <th>Plus d'info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $listeTournois->afficherTournois();?>
                        <tr>
                            <td><a href="./DetailsTournoi.html">+</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>