<?php
include './modele/Connexion.php';
include './modele/Tournois.php';
$connx = Connexion::getInstance();
$listeTournois = new Tournois();
$listeTournois->tousLesTournois();
if(isset($_GET['nom'])){
    if($_GET['nom']){
        $listeTournois->tournoiDe($_GET['nom']);
    }else{
        $listeTournois->tousLesTournois();
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
<body class="tournois">
    <!--Menu de navigation-->
    <header>
        <div class="Menu">
            <div class="menunav">
            <nav class="navig">
                <a href="./index.php">Home</a>
                <a href="./ListeTournois.php">Liste des Tournois</a>
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
                            echo '<h3>Bonjour '.$connx->getRole().' '.$connx->getIdentifiant().'</h3>'.' <a href="index.php?sedeconnecter=true" name="deconnecter"> se deconnecter </a>';
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
            <div>
                <h3> Saisir nom jeu pour rechercher</h3>
                <form action="ListeTournois.php" method="GET">
                Nom Jeu: <input type="text" name="nom" value=""><br>
                <input type="submit" value="rechercher">
                <input type="submit" value="reset">
                </form>
            </div>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>CashPrize</th>
                            <th>Notoriété</th>
                            <th>Lieu</th>
                            <th>Heure de début</th>
                            <th>Date</th>
                            <th>Fin Inscription</th>
                            <th>Jeu</th>
                            <th>Plus d'info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $listeTournois->afficherTournois();?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>