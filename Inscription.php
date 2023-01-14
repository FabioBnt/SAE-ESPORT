<?php
    include_once './modele/Connexion.php';
    $connx = Connexion::getInstance();
    if (isset($_GET['sedeconnecter'])){
        $connx->seDeconnecter();
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
<body class="inscription">
    <!--Menu de navigation-->
    <header>
            <div class="menunav">
                <button class="buttonM" onclick="window.location.href='./index.php'">Accueil</button>
                <button class="buttonM" onclick="window.location.href='./ListeTournois.php'">Liste des Tournois</button>
                <button class="buttonM" onclick="window.location.href='./Classement.php'">Classement</button>
            </div>
            <div class="menucenter">
                <img class="logo" src="./img/logo header.png">
            </div>
            <div class="menuright">  
                    <?php 
                        if($connx->getRole() === Role::Visiteur){
                            echo '<a href="./ConnexionPage.php" id="connexion">Se Connecter</a>';
                        }else{
                            echo '<div class="disconnect"><h3>Bonjour, '.$connx->getIdentifiant().'</h3>'.' <a href="index.php?SeDeconnecter=true" id="deconnexion">Deconnexion</a></div>';
                        }
                    ?>
            </div>      
    </header>
    <main class="InscriptionM">
        <label>Etes-vous sûr de vouloir s'inscrire à ce tournoi ?</label>
        <a href="./ListeTournois.php" class="buttonE" id="gridIa1">Retour</a>
        <a href="./ListeTournois.php" class="buttonE" id="gridIa2">Valider</a>
    </main>
</body>
</html>