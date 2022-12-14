
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
                            <td><a href="DetailsEquipe.php">+</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>MenwizzGaming</td>
                            <td>2420</td>
                            <td><a href="DetailsEquipe.php">+</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>