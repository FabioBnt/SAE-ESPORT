﻿
<?php 
    include './modele/Connexion.php';
    $connx = Connexion::getInstance();
    if (isset($_GET['sedeconnecter'])) {
        $connx->seDeconnecter();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>E-Sporter Manager</title>
</head>
<body class="classement">
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
                <img class="logo" src="./img/logo header.png">
            </div>
            </div>
            <div class="menuright">
                <div class="connecter">
                    <?php 
                        if($connx->getRole() == Role::Visiteur){
                            echo '<a href="./ConnexionPage.php" id="connexion">Se Connecter</a>';
                        }else{
                            echo '<div class="deconnect"><h3>Bonjour '.$connx->getRole().' '.$connx->getIdentifiant().'</h3>'.' <a href="index.php?SeDeconnecter=true" name="deconnecter" id="deconnexion">Deconnexion</a></div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="classementmain">
            <h1>Classement Général</h1>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th >Place</th>
                            <th >Nom</th>
                            <th >Nb de Points</th>
                            <th >Plus d'informations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Vitality</td>
                            <td>2455</td>
                            <td><a href="DetailsEquipe.html">+</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>MenwizzGaming</td>
                            <td>2420</td>
                            <td><a href="DetailsEquipe.html">+</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>