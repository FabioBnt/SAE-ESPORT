<?php
    include './modele/Connexion.php';
    session_start();
    if(!isset($_SESSION["connexion"]))
    {
        $singleton = Connexion::getInstance();
        $_SESSION['connexion'] = $singleton;
    }
    $connx = $_SESSION['connexion'];
    if (isset($_GET['sedeconnecter'])) {
        $connx->seDeconnecter();
      }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
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
<body class="accueil">
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
    <main class="accueilmain">
        <div class="mainA">
            <div class="titre">
                <h1> Gestionnaire d'une saison de compétition de Esport </h1>
            </div>
            <div id="divbutton">
                <button class="buttonM" onclick="window.location.href = 'CreerTournoi.php';" type="button"> Créer un tournoi </button>
                <button class="buttonM" onclick="window.location.href = 'ListeEquipe.html';" type="button"> Liste des équipes </button>
                <button class="buttonM" onclick="window.location.href = 'CreerEcurie.php';" type="button"> Créer une écurie </button>
            </div>
            <div id="paragraphe">
                <p>
                    WIP
                </p>
            </div>
            <div id="paragraphe2">
                <p>
                    WIP
                </p>
            </div>
        </div>
    </main>
</body>
</html>