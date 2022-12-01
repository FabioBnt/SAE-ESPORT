<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css" />
    <title>E-Sporter Manager</title>
</head>
<body class="detailstournoi">
    <!--Menu de navigation-->
    <header>
        <div class="Menu">
            <div class="menunav">
            <nav class="navig">
                <a href="./index.php">Home</a>
                <a href="./ListeTournois.php">Liste des Tournois</a>
                <a href="./Classement.html">Classement</a>
            </nav>
            <div class="menucenter">
                <img class="logo" src="./img/logo header.png">
            </div>
            </div>
            <div class="menuright">
                <div class="connecter">
                    <a href="./ConnexionPage.php" id="connexion">Se Connecter</a>
                </div>
            </div>
        </div>
    </header>
    <main>
        <?php
        include './modele/Connexion.php';
        include './modele/Tournois.php';
        $connx = Connexion::getInstance();
        $data = $connx->select("T.*", "Tournois T", "where NomTournoi=".$_POST["IDT"]);

        ?>
        <div class="detailstournoimain">
            <div class="Divdetails">
                <h1>Details d'un Tournoi</h1>
                <div class="gridDetails">
                    <label id="Dgridl1"><b>Nom du tournoi</b></label>
                    <input id="Dgridi1" type="text" name="nameT" value="" readonly>
                    <label id="Dgridl2"><b>Date du tournoi</b></label>
                    <input id="Dgridi2" type="text" name="dateT" value="" readonly>
                    <label id="Dgridl3"><b>Heure du tournoi</b></label>
                    <input id="Dgridi3" type="text" name="heureT" value="" readonly>
                    <label id="Dgridl4"><b>Lieu du tournoi</b></label>
                    <input id="Dgridi4" type="text" name="lieuT" value="" readonly>
                    <label id="Dgridl5"><b>CashPrize</b></label>
                    <input id="Dgridi5" type="text" name="cashprizeT" value="" readonly>
                    <label id="Dgridl6"><b>Notoriété</b></label>
                    <input id="Dgridi6" type="text" name="notorieteT" value="" readonly>
                    <table id="Dgridt1">
                        <thead>
                            <tr>
                                <th >Jeu</th>
                                <th >Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Minecraft</td>
                                <td><a href="Score.html">+</a></td>
                            </tr>
                            <tr>
                                <td>Fortnite</td>
                                <td><a href="Score.html">+</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="./ListeTournois.php" class="buttonE">Retour</a>
            </div>
        </div>
    </main>
</body>
</html>