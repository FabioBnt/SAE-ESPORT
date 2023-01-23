<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../modele/Connexion.php';
include '../modele/Ecurie.php';
include '../modele/Jeu.php';
include '../modele/Equipe.php';
$connx = Connexion::getInstance();
if ($connx->getRole() == Role::Ecurie) {
    $id = Ecurie::getIDbyNomCompte($connx->getIdentifiant());
}
$listeJeux = Jeu::JeuEquipeNJ($id);   
if (isset($_POST['name'])) {
    if ($connx->getRole() == Role::Ecurie) {
        $Ecurie = Ecurie::getEcurie($id);
        $Ecurie->creerEquipe($_POST['name'], $_POST['username'], $_POST['password'], $_POST['jeuE'], Ecurie::getIDbyNomCompte($connx->getIdentifiant()));
        echo '<script>alert("La ligne a bien été inserée")</script>';
        $IdEquipe = Equipe::getIDbyNom($_POST['name']);
        if (!empty($_POST['pseudo1'])) {
            $Ecurie->ajouterJoueur($_POST['pseudo1'], $_POST['nat1'], $IdEquipe);}
        if (!empty($_POST['pseudo2'])) {
            $Ecurie->ajouterJoueur($_POST['pseudo2'], $_POST['nat2'], $IdEquipe);}
        if (!empty($_POST['pseudo3'])) {
            $Ecurie->ajouterJoueur($_POST['pseudo3'], $_POST['nat3'], $IdEquipe);}
        if (!empty($_POST['pseudo4'])) {
            $Ecurie->ajouterJoueur($_POST['pseudo4'], $_POST['nat4'], $IdEquipe);}
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
    <link rel="stylesheet" href="../style.css" />
    <title>E-Sporter Manager</title>
</head>
<body class="equipe">
    <!--Menu de navigation-->
    <header>
        <div class="menunav">
            <button class="buttonM" onclick="window.location.href='../index.php'">Accueil</button>
            <button class="buttonM" onclick="window.location.href='./ListeTournois.php'">Liste des Tournois</button>
            <button class="buttonM" onclick="window.location.href='./Classement.php'">Classement</button>
        </div>
        <div class="menucenter">
            <img class="logo" src="../img/logo header.png">
        </div>
        <div class="menuright">
            <?php
            if ($connx->getRole() == Role::Visiteur) {
                echo '<a href="./ConnexionPage.php" id="connexion">Se Connecter</a>';
            } else {
                echo '<div class="disconnect"><h3>Bonjour, ' . $connx->getIdentifiant() . '</h3>' . ' <a href="../index.php?SeDeconnecter=true" id="deconnexion">Deconnexion</a></div>';
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
                            echo '<option value=' . $jeu->getId() . '>' . $jeu->getNom() . '</option>';
                        }
                        ?>
                    </select>
                    <table id="TabEquipeC">
                        <thead>
                            <tr>
                                <th>Pseudo</th>
                                <th>Nationalité</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input placeholder="Anonyme" type="text" name="pseudo1"></td>
                                <td><input placeholder="FR, EN, DE etc" type="text" name="nat1"></td>
                            </tr>
                            <tr>
                                <td><input placeholder="Anonyme" type="text" name="pseudo2"></td>
                                <td><input placeholder="FR, EN, DE etc" type="text" name="nat2"></td>
                            </tr>
                            <tr>
                                <td><input placeholder="Anonyme" type="text" name="pseudo3"></td>
                                <td><input placeholder="FR, EN, DE etc" type="text" name="nat3"></td>
                            </tr>
                            <tr>
                                <td><input placeholder="Anonyme" type="text" name="pseudo4"></td>
                                <td><input placeholder="FR, EN, DE etc" type="text" name="nat4"></td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="submit" class="buttonE" id="validerE" value='VALIDER'>
                    <input type="button" class="buttonE" id="annulerE" value='ANNULER' onclick="history.back()">
                </div>
            </form>
        </div>
    </main>
</body>
</html>