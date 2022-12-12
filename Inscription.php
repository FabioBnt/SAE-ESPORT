<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css" />
    <title>E-Sporter Manager</title>
</head>
<body class="inscription">
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
                    <a href="./Connexion.php" id="connexion">Se Connecter</a>
                </div>
            </div>
        </div>
    </header>
    <main class="InscriptionM">
        <label>Etes-vous sûr de vouloir s'inscrire à ce tournoi ?</label>
        <a href="./ListeTournois.php" class="buttonE" id="gridIa1">Retour</a>
        <a href="./ListeTournois.php" class="buttonE" id="gridIa2">Valider</a>
    </main>
</body>
</html>