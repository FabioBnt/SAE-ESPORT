<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    include './modele/Connexion.php';
    include './modele/Ecurie.php';
    include './modele/Jeu.php';
    $connx = Connexion::getInstance();
    $listeJeux = Jeu::tousLesJeux();
    if(isset($_POST['name'])){
        if($connx->getRole() == Role::Ecurie){
            $id = Ecurie::getIDbyNomCompte($connx->getIdentifiant());
            $Ecurie = Ecurie::getEcurie($id);
            $Ecurie->creerEquipe($_POST['name'], $_POST['username'], $_POST['password'], $_POST['jeuE'], Ecurie::getIDbyNomCompte($connx->getIdentifiant()) );
            echo '<script>alert("La ligne a bien été inserée")</script>';
        }
    }
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
        <div class="equipemain">
            <form action="./CreerEquipe.php" id="formeequipe" method="POST">
                <h1>Créer une équipe</h1>
                <div class="formulaire">
                    <label id="Eqforml1"><b>Nom de l'équipe</b></label>
                    <input id="Eqformi1" type="text" placeholder="Entrer le nom de l'équipe" name="name" required>
                    <label id="Eqforml2"><b>Nom du compte</b></label>
                    <input id="Eqformi2" type="text" placeholder="Entrer l'identifiant" name="username" required>
                    <label id="Eqforml3"><b>Mot de passe</b></label>
                    <input id="Eqformi3" type="password" placeholder="Entrer le mot de passe" name="password" required>
                    <label id="Eqforml4"><b>Jeu</b></label>
                    <select name="jeuE" id="Eqformt1">
                        <?php 
                    foreach ($listeJeux as $jeu) {
                            echo '<option value='.$jeu->getId().'>'.$jeu->getNom().'</option>';
                        } 
                        ?>
                    </select>
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