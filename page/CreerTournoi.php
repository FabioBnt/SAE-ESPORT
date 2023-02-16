<?php
include_once '../modele/Connexion.php';
include_once '../modele/Administrateur.php';
include_once '../modele/Jeu.php';
$connx = Connexion::getInstance();
$listeJeux = Jeu::tousLesJeux();
//Checks if the user is connected and if he is an admin
if ($connx == null || $connx->getRole() != Role::Administrateur) {
    header('Location: ../index.php');
}
if (isset($_POST['name'])) {
    if ($connx->getRole() == Role::Administrateur) {
        $Admin = new Administrateur();
        $cash = $_POST['cashprize'];
        if ($cash < 0) {
            $cash = 0;
        }
        $Admin->creerTournoi($_POST['name'], $cash, $_POST['typeT'], $_POST['lieu'], $_POST['heure'], $_POST['date'], $_POST['jeuT']);
        echo '<script>alert("La ligne a bien été insérée")</script>';
    } else {
        echo '<script>alert("Il faut etre connecté en tant que Administateur")</script>';
    }
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

<body class="tournoi">
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
        <div class="tournoimain">
            <form action="CreerTournoi.php" id="formetournoi" method="POST">
                <h1>Créer un tournoi</h1>
                <div class="formulaire">
                    <label id="Tforml1"><b>Nom du tournoi</b></label>
                    <input id="Tformi1" type="text" placeholder="Entrer le nom du tournoi" name="name" required>
                    <label id="Tforml2"><b>Date</b></label>
                    <!-- date not before one month of today make that date as default date -->
                    <?php $date = date('Y-m-d', strtotime('+1 month')); ?>
                    <input id="Tformi2" type="date" name="date" min="<?php echo $date; ?>" value="<?php echo $date; ?>" required>
                    <label id="Tforml3"><b>Heure</b></label>
                    <input id="Tformi3" type="time" name="heure" required>
                    <label id="Tforml4"><b>Lieu</b></label>
                    <input id="Tformi4" type="text" placeholder="Entrer le lieu" name="lieu" required>
                    <label id="Tforml5"><b>Cashprize</b></label>
                    <input id="Tformi5" type="number" placeholder="Entrer le montant du cashprize" name="cashprize" required>
                    <label id="Tforml6"><b>Notoriété</b></label>
                    <select id="Tformt1" name="typeT">
                        <option value="Local">Local</option>
                        <option value="Regional">Regional</option>
                        <option value="International">International</option>
                    </select>
                    <label id="Tformt2">Jeux</label>
                    <div id="jeux">
                        <?php
                        foreach ($listeJeux as $jeu) {
                            echo '<div><input type="checkbox" name="jeuT[]" value="' . $jeu->getId() . '"> ' . $jeu->getNom() . '</div>';
                        }
                        ?>
                    </div>
                    <input type="submit" class="buttonE" id="validerT" value='VALIDER'>
                    <input type="button" class="buttonE" id="annulerT" value='ANNULER' onclick="history.back()">
                </div>
            </form>
        </div>
    </main>
</body>

</html>