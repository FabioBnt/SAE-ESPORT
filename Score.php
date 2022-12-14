
<?php
include './modele/Connexion.php';
include './modele/Tournois.php';
$connx = Connexion::getInstance();
$mysql = Database::getInstance();
$listePoules = $_SESSION['jeu'.$_GET['IDJ']];
$nomTournoi = $_GET['NomT'];
$nomJeu = $_GET['JeuT'];

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
        <a href="javascript:history.go(-1)" class="buttonE" id="RetourS8">Retour</a>
        <h1 id="labelS1">Score du Tournoi <?php echo (string)$nomTournoi.'<br>'. (string)$nomJeu ?> </h1>
        <a href="#" class="buttonE" id="ModifS7">Modification</a>
        <?php
        $i = 0;
        foreach ($listePoules[$_GET['IDJ']] as $poule) {
            $i++;
            echo '<table id="tableS'.$i.'"><thead><tr><th colspan="4">Poule ';
             if($i==5){echo'Finale';}else{echo $i;};
              echo '</th></tr><tr><th>Equipe 1</th><th>Score</th><th>Equipe 2</th><th>Score</th></tr></thead><tbody>';
            foreach ($poule->getMatchs() as $match){
                echo $match->afficherEquipes();
            }
            echo '</tbody></table>';
        }
        ?>
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
    </main>
</body>
</html>