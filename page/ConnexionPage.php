﻿<?php
    include '../modele/Connexion.php';
    $connx = Connexion::getInstance();
    if(isset($_POST['username']) && isset($_POST['password'])){
        $connx->seConnecter($_POST['username'], $_POST['password'], $_POST['roles']);
        if($connx->getRole() == $_POST['roles']){
            header("Location: ../index.php");
        }else{
            echo '<h1 style="color:red;text-align:center;">Identifiant ou mot de passe incorrect</h1>';
        }
    }
?>
<html>
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styleConnexion.css" />
 </head>
 <body>
 <div id="seconnecter">    
    <form action="ConnexionPage.php" method="POST">
        <h1>Connexion</h1>
        <label for="roles">Choisissez un rôle :</label>
        <select class="radio" name="roles">
            <option value="Ecurie">Ecurie</option>
            <option value="Equipe">Equipe</option>
            <option value="Arbitre">Arbitre</option>
            <option value="Administrateur">Administrateur</option>
        </select> <br>
        <label><b>Nom d'utilisateur</b></label>
        <input type="text" placeholder="Entrer le nom d'utilisateur" name="username" required>
        <label><b>Mot de passe</b></label>
        <input type="password" placeholder="Entrer le mot de passe" name="password" required>
        <input type="submit" id='submit' value='CONNEXION' >
        <input type="button" value='ANNULER' onclick="history.back()"> <!--Permet de retourner à la page d'avant (historique)-->
    </form>
 </div>
 </body>
</html>