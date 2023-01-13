<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include './modele/Connexion.php';
include './modele/Classement.php';
include_once './modele/Jeu.php';
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
        <div class="menunav">
            <button class="buttonM" onclick="window.location.href='./index.php'">Home</button>
            <button class="buttonM" onclick="window.location.href='./ListeTournois.php'">Liste des Tournois</button>
            <button class="buttonM" onclick="window.location.href='./Classement.php'">Classement</button>
        </div>

        <div class="menucenter">
            <img class="logo" src="./img/logo header.png" alt="logo">
        </div>

        <div class="menuright">
            <?php
            if ($connx->getRole() == Role::Visiteur) {
                echo '<a href="./ConnexionPage.php" id="connexion">Se Connecter</a>';
            } else {
                echo '<div class="disconnect"><h3>Bonjour, ' . $connx->getIdentifiant() . '</h3>' . ' <a href="index.php?SeDeconnecter=true" id="deconnexion">Deconnexion</a></div>';
            }
            ?>
        </div>
    </header>
    <main>
        <div class="classementmain">
            <form action="./Classement.php">
                <h1>Sélectionner un jeu</h1>
                <select name="jeuC" id="Clformt1">
                    <?php
                    $listeJeux = Jeu::tousLesJeux();
                    foreach ($listeJeux as $jeu) {
                        echo '<option value="' . $jeu->getId() . '">' . $jeu->getNom() . '</option>';
                    }
                    ?>
                </select>
                <input class="buttonE" type="submit" value="Valider">
            </form>
            <?php if(isset($_GET['jeuC'])){
               echo '<h1>Classement du jeu '.$choix = Jeu::getJeuById($_GET['jeuC'])->getNom().'</h1>';
            } ?>

            <div>
                <table>
                    <thead>
                        <tr>
                            <th>Place</th>
                            <th>Nom</th>
                            <th>Nb de Points</th>
                            <th>Plus d'informations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(isset($_GET['jeuC'])){
                                $Classement = new Classement($_GET['jeuC']);
                                $Classement->afficherClassement($_GET['jeuC']);
                            }
                         ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>