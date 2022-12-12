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
    <link rel="stylesheet" href="./style.css" />
    <title>E-Sporter Manager</title>
</head>
<body class="listeEquipe">
    <!--Menu de navigation-->
    <header>
        <div class="Menu">
            <div class="menunav">
            <nav class="navig">
                <a href="./index.php">Home</a>
                <a href="./ListeTournois.php">Liste des Tournois</a>
                <a href="./Classement.php">Classement</a>
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
        <div class="listeEquipemain">
            <div class="divEquip1">
                <a href="./CreerEquipe.php" class="buttonE" id="BtnCEquipe">Créer Equipe</a>
            </div>
            <h1>Liste Des Equipes</h1>
            <div>
                <table id="TabEquipe">
                    <thead>
                        <tr>
                            <th >Nom</th>
                            <th >Plus d'informations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>WALA</td>
                            <td><a href="./DetailsEquipe.php">+</a></td>
                        </tr>
                        <tr>
                            <td>CMOI</td>
                            <td><a href="./DetailsEquipe.php">+</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>