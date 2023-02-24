<!--header-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css" />
    <title>E-Sporter Manager</title>
</head>
<body class="header">
    <!--Menu de navigation-->
    <header>
            <div class="menunav">
                <a class="buttonM" href="./index.php?page=accueil">Accueil</a>
                <a class="buttonM" href="./index.php?page=listetournoi">Liste des Tournois</a>
                <a class="buttonM" href="./index.php?page=classement">Classement</a>
                <?php if($connx->getRole() == Role::Administrator):?>
                <a class="buttonM" href="./index.php?page=creertournoi">Créer Tournoi</a>
                <a class="buttonM" href="./index.php?page=creerecurie">Créer Ecurie</a>
                <?php endif;?>
                <?php if($connx->getRole() == Role::Organization):?>
                <a class="buttonM" href="./index.php?page=creerequipe">Créer Equipe</a>
                <?php endif;?>
            </div>
            <div class="menucenter">
                <img class="logo" src="./img/logo header.png" alt="LogoDuSite">
            </div>
            <div class="menuright">
                <?php if($connx->getRole() == Role::Visiteur):?>
                    <a href="./index.php?page=connectionview" id="Connection">Se Connecter</a>
                <?php else :?>
                    <h3>Bienvenue, <?php echo $connx->getIdentifiant(); ?></h3>
                    <a href="./index.php?page=accueil&sedeconnecter=true" id="deconnexion">Déconnexion</a>
                <?php endif;?>
            </div>      
    </header>