
<?php
include './modele/Connexion.php';
include './modele/Tournois.php';
$connx = Connexion::getInstance();
$mysql = Database::getInstance();
$listePoules = $_SESSION['jeu'.$_GET['IDJ']];
$nomTournoi = $_GET['NomT'];

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
<body class="score">
    <!--Menu de navigation-->
    <header>
            <div class="menunav">
                <button class="buttonM" onclick="window.location.href='./index.php'">Home</button>
                <button class="buttonM" onclick="window.location.href='./ListeTournois.php'">Liste des Tournois</button>
                <button class="buttonM" onclick="window.location.href='./Classement.php'">Classement</button>
            </div>

            <div class="menucenter">
                <img class="logo" src="./img/logo header.png">
            </div>

            <div class="menuright">  
                    <?php 
                        if($connx->getRole() == Role::Visiteur){
                            echo '<a href="./ConnexionPage.php" id="connexion">Se Connecter</a>';
                        }else{
                            echo '<div class="disconnect"><h3>Bonjour, '.$connx->getIdentifiant().'</h3>'.' <a href="index.php?SeDeconnecter=true" id="deconnexion">Deconnexion</a></div>';
                        }
                    ?>
            </div>      
    </header>
    <main class="scoredetails">
        <h1 id="labelS1">Score du Tournoi <?php echo (string)$nomTournoi ?></h1>
        <table id="tableS1">
            <thead>
                <tr>
                    <th>Poule 1</th>
                    <th>Points</th>
                    <th>Ecurie</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($listePoules[$_GET['IDJ']] as $poule) {
                        foreach ($poule->getMatchs() as $match){
                            echo $match->afficherEquipes();
                        }
                    }
                ?>
            </tbody>
        </table>
        <table id="tableS2">
            <thead>
                <tr>
                    <th>Poule 2</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                    <td>Equipe 1</td>
                    <td>Equipe 2</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 3</td>
                    <td>Equipe 4</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 1</td>
                    <td>Equipe 3</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 2</td>
                    <td>Equipe 4</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 1</td>
                    <td>Equipe 4</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 3</td>
                    <td>Equipe 2</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
            </tbody>
        </table>
        <table id="tableS3">
            <thead>
                <tr>
                    <th>Poule 3</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                    <td>Equipe 1</td>
                    <td>Equipe 2</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 3</td>
                    <td>Equipe 4</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 1</td>
                    <td>Equipe 3</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 2</td>
                    <td>Equipe 4</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 1</td>
                    <td>Equipe 4</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 3</td>
                    <td>Equipe 2</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
            </tbody>
        </table>
        <table id="tableS4">
            <thead>
                <tr>
                    <th>Poule 4</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                    <td>Equipe 1</td>
                    <td>Equipe 2</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 3</td>
                    <td>Equipe 4</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 1</td>
                    <td>Equipe 3</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 2</td>
                    <td>Equipe 4</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 1</td>
                    <td>Equipe 4</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 3</td>
                    <td>Equipe 2</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
            </tbody>
        </table>
        <table id="tableS5">
            <thead>
                <tr>
                    <th>Poule Finale</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                    <td>Equipe 1</td>
                    <td>Equipe 2</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 3</td>
                    <td>Equipe 4</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 1</td>
                    <td>Equipe 3</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 2</td>
                    <td>Equipe 4</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 1</td>
                    <td>Equipe 4</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Equipe 3</td>
                    <td>Equipe 2</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
            </tbody>
        </table>
        <table id="tableS6">
            <thead>
                <tr>
                    <th>Classement</th>
                    <th>Place</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Equipe 1</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Equipe 3</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>Equipe 4</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>Equipe 2</td>
                    <td>4</td>
                </tr>
            </tbody>
        </table>
        <a href="#" class="buttonE" id="ModifS7">Modification</a>
        <a href="javascript:history.go(-1)" class="buttonE" id="RetourS8">Retour</a>
    </main>
</body>
</html>