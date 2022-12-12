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
<body class="equipe">
    <!--Menu de navigation-->
    <header>
        <div class="Menu">
            <div class="menunav">
            <nav class="navig">
                <a href="index.php">Home</a>
                <a href="ListeTournois.php">Liste des Tournois</a>
                <a href="Classement.php">Classement</a>
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
        <div class="equipemain">
            <form action="ListeEquipe.php" id="formeequipe" method="POST">
                <h1>Créer une équipe</h1>
                <div class="formulaire">
                    <label id="Eqforml1"><b>Nom de l'équipe</b></label>
                    <input id="Eqformi1" type="text" placeholder="Entrer le nom de l'équipe" name="name" required>
                    <label id="Eqforml2"><b>Nom du compte</b></label>
                    <input id="Eqformi2" type="text" placeholder="Entrer l'identifiant" name="username" required>
                    <label id="Eqforml3"><b>Mot de passe</b></label>
                    <input id="Eqformi3" type="password" placeholder="Entrer le mot de passe" name="password" required>
                    <label id="Eqforml4"><b>Type du jeu</b></label>
                    <input id="Eqformt1" type=text list=typeE placeholder="Choisissez le type de jeu">
                        <datalist id=typeE >
                        <option> FPS
                        <option> MOBA
                        <option> SPORT
                        <option> BATTLEROYALE
                        </datalist>
                    <table id="TabEquipeC">
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
                        </tbody>
                    </table>
                    <input type="submit" class="buttonE" id="validerE" value='VALIDER' >
                    <input type="button" class="buttonE" id="annulerE" value='ANNULER' onclick="history.back()" >
                </div>
            </form>
        </div>
    </main>
</body>
</html>