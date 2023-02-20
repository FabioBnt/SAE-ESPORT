<!--header-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css" />
    <title>E-Sporter Manager</title>
</head>
<body class="header">
    <!--Menu de navigation-->
    <header>
            <div class="menunav">
                <a class="buttonM" href="./index.php?page=accueil">Accueil</a>
                <a class="buttonM" href="./index.php?page=listetournoi">Liste des Tournois</a>
                <a class="buttonM" href="./index.php?page=classement">Classement</a>
                <?php if(isset($_GET['role']) && $_GET['role']=='Administrateur'):?>
                <a class="buttonM" href="./index.php?page=creertournoi">Créer Tournoi</a>
                <a class="buttonM" href="./index.php?page=creerecurie">Créer Ecurie</a>
                <?php endif;?>
                <?php if(isset($_GET['role']) && $_GET['role']=='Ecurie'):?>
                <a class="buttonM" href="./index.php?page=creerequipe">Créer Equipe</a>
                <?php endif;?>
            </div>
            <div class="menucenter">
                <img class="logo" src="./img/logo header.png" alt="LogoDuSite">
            </div>
            <div class="menuright">
                <?php if(isset($_GET['conn']) && $_GET['conn']==1):?>
                    <a href="./index.php?page=accueil&conn=0" id="deconnexion">Déconnexion</a>
                <?php else :?>
                    <a href="./index.php?page=connexionvue" id="connexion">Se Connecter</a>
                <?php endif;?>
            </div>      
    </header>