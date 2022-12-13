<?php
        include './modele/Connexion.php';
        include './modele/Tournois.php';
        $connx = Connexion::getInstance();
        $mysql = Database::getInstance();
        $listeTournois = new Tournois;
        $listeTournois->tousLesTournois();
        $idTournoi = $_GET['IDT'];
        $tournoi = $listeTournois->getTournoi($idTournoi);

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
<body class="detailstournoi">
    <!--Menu de navigation-->
    <header>
        <div class="Menu">
            <div class="menunav">
            <nav class="navig">
                <a href="./index.php">Home</a>
                <a href="./ListeTournois.php">Liste des Tournois</a>
                <a href="./Classement.php">Classement</a>
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
        <div class="detailstournoimain">
            <div class="Divdetails">
                <h1>Details d'un Tournoi</h1>
                <div class="gridDetails">
                    <label id="Dgridl1"><b>Nom du tournoi</b></label>
                    <input id="Dgridi1" type="text" name="nameT" value='<?php echo $tournoi->getNom(); ?>' readonly>
                    <label id="Dgridl2"><b>Date du tournoi</b></label>
                    <input id="Dgridi2" type="text" name="dateT" value='<?php echo $tournoi->getDate() ?>' readonly>
                    <label id="Dgridl3"><b>Heure du tournoi</b></label>
                    <input id="Dgridi3" type="text" name="heureT" value='<?php echo $tournoi->getHeureDebut(); ?>' readonly>
                    <label id="Dgridl4"><b>Lieu du tournoi</b></label>
                    <input id="Dgridi4" type="text" name="lieuT" value='<?php echo $tournoi->getLieu(); ?>' readonly>
                    <label id="Dgridl5"><b>CashPrize</b></label>
                    <input id="Dgridi5" type="text" name="cashprizeT" value='<?php echo $tournoi->getCashPrize(); ?>' readonly>
                    <label id="Dgridl6"><b>Notoriété</b></label>
                    <input id="Dgridi6" type="text" name="notorieteT" value='<?php echo $tournoi->getNotoriete() ?>' readonly>
                    <table id="Dgridt1">
                        <thead>
                            <tr>
                                <th >Jeu</th>
                                <th >Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php foreach ($tournoi->getJeux() as $jeu) {
                                echo '<tr><td>'.$jeu->getNom()."<td><a href='./Score.php?IDJ=".$jeu->getId().'&NomT='.$tournoi->getNom()."'>+</a></td>".'</tr>';
                                $_SESSION['jeu'.$jeu->getId()] = $tournoi->getPoules();
                            } ?>
                            
                        </tbody>
                    </table>
                    <a href="./Inscription.php" class="buttonE" id="Dgrida1">S'inscrire</a>
                    <table id="Dgridt2">
                        <thead>
                            <tr>
                                <th >Participant</th>
                                <th >Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tournoi->lesEquipesParticipants() as $participant) {
                                echo '<tr>'.'<td>'.$participant.'</td>'.'<td><a href="DetailsEquipe.php">+</a></td>'.'</tr>';
                            } ?>
                        </tbody>
                    </table>
                    <a href="javascript:history.go(-1)" class="buttonE" id="Dgrida2">Retour</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>