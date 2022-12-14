<?php
include './modele/Connexion.php';
include './modele/Tournois.php';
$connx = Connexion::getInstance();
$listeTournois = new Tournois();
$listeTournois->tousLesTournois();
if(isset($_GET['jeu'])){
    if($_GET['jeu']){
        $listeTournois->tournoiDe($_GET['jeu']);
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
    
        <div class="tournoismain">
            <h1>Liste des Tournois</h1>
            <div>
            <div>
                <h3> Filtre de recherche : </h3>
                <form action="ListeTournois.php" class="RechercheL" method="GET">
                Jeu : <input type="text" name="jeu" value="">
                Nom : <input type="text" name="nom" value=""> <!--non fonctionnel-->
                Notoriete : <input type="text" name="notoriete" value=""><br> <!--non fonctionnel-->
                Date : <input type="text" name="date" value=""> <!--non fonctionnel-->
                Lieu : <input type="text" name="lieu" value=""><br> <!--non fonctionnel-->
                <input type="submit" value="reset">
                <input type="submit" value="rechercher">
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