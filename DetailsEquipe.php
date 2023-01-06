﻿<?php 
    include './modele/Connexion.php';
    include './modele/Tournois.php';
    include './modele/Equipes.php';
    $connx = Connexion::getInstance();
    $mysql = Database::getInstance();
    $listeEquipes = new Equipes;
    $listeEquipes->tousLesEquipes();
    $idEquipe = $_GET['IDE'];
    $equipe = $listeEquipes->getEquipe($idEquipe);
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
<body class="equipeD">
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
        <div class="detailsequipemain">
            <div class="Divdetails">
                <h1>Details d'une équipe</h1>
                <div class="gridDetails">
                    <label id="EDgridl1"><b>Nom de l'équipe</b></label>
                    <input id="EDgridi1" type="text" name="nameE" value='<?php echo $equipe->getNom(); ?>' readonly>
                    <label id="EDgridl2"><b>Nom du Jeu</b></label>
                    <input id="EDgridi2" type="text" name="jeu" value='<?php 
                    $mysql = Database::getInstance();
                    $data = $mysql->selectL("J.NomJeu",
                    "Jeu J", "where J.IdJeu =".$equipe->getJeu().'');
                    echo $data['NomJeu'];
                    ?>' readonly>
                    <label id="EDgridl3"><b>Nom de l'écurie</b></label>
                    <input id="EDgridi3" type="text" name="ecurieE" value='<?php echo $equipe->getEcurie(); ?>' readonly>
                    <table id="EDgridt1">
                        <thead>
                            <tr>
                                <th >Pseudo</th>
                                <th >Nationalité</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>BONJOUR</td>
                                <td>FR</td>
                            </tr>
                            <tr>
                                <td>BONSOIR</td>
                                <td>EN</td>
                            </tr>
                            <tr>
                                <td>BONSOIR2</td>
                                <td>EN</td>
                            </tr>
                            <tr>
                                <td>BONSOIR3</td>
                                <td>EN</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="javascript:history.go(-1)" class="buttonE" id="EDgridb1">Retour</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>