<?php
    include './modele/Connexion.php';
    include './modele/Tournois.php';
    $connx = Connexion::getInstance();
    $listeTournois = new Tournois();
    $listeTournois->tousLesTournois();
    if (isset($_GET['jeu']) || isset($_GET['nom']) || isset($_GET['prixmin']) || isset($_GET['prixmax'])
    || isset($_GET['notoriete']) || isset($_GET['lieu']) || isset($_GET['date'])) {
    $jeu = "";
    $nom = "";
    $date = "";
    $lieu = "";
    $notoriete = "";
    if ($_GET['jeu']){
        $jeu = $_GET['jeu'];
    }
    if ($_GET['nom']){
        $nom = $_GET['nom'];
    }
    if ($_GET['date']){
        $date = $_GET['date'];
    }
    if($_GET['notoriete']){
        $notoriete = $_GET['notoriete'];
    }
    if ($_GET['lieu']){
        $lieu = $_GET['lieu'];
    }
    try {
        $listeTournois->tournoiDe($jeu,$nom, (int)$_GET['prixmin'], (int)$_GET['prixmax'], $notoriete, $lieu, $date);
    } catch (Exception $e) {
        echo "<script>alert('Filtrage impossible !')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css"/>
    <title>E-Sporter Manager</title>
</head>
<body class="tournois">
<!--Menu de navigation-->
<header>
    <div class="menunav">
        <button class="buttonM" onclick="window.location.href='./index.php'">Accueil</button>
        <button class="buttonM" onclick="window.location.href='./ListeTournois.php'">Liste des Tournois</button>
        <button class="buttonM" onclick="window.location.href='./Classement.php'">Classement</button>
    </div>
    <div class="menucenter">
        <img class="logo" src="./img/logo header.png" alt="logo">
    </div>
    <div class="menuright">
        <?php
        if ($connx->getRole() == Role::Visiteur) {
            echo '<a href="./ConnexionPage.php" id="connexion">Se Connecter</a>';
        } else {
            echo '<div class="disconnect"><h3>Bonjour, ' . $connx->getIdentifiant() . '</h3>' . ' <a href="index.php?SeDeconnecter=true" id="deconnexion">Deconnexion</a></div>';
        }
        ?>
    </div>
</header>
<main>
    <div class="tournoismain">
        <h1>Liste des Tournois</h1>
        <div>
            <div>
                <p><b>Information :</b> Les points d'un tournoi sont donnés aux 4 premières équipes par Jeu et des
                    multiplicateurs sont associés en fonction de la notoriété. Le cashprize revient à la première équipe !
                </p>
            </div>
            <div>
                <h3> Filtre de recherche : </h3>
                <form action="ListeTournois.php" class="RechercheL" method="GET">
                    Jeu : <label>
                        <input type="text" name="jeu" value="">
                    </label>
                    Nom : <label>
                        <input type="text" name="nom" value="">
                    </label> <!--non fonctionnel-->
                    Notoriété : <label>
                        <input type="text" name="notoriete" value="">
                    </label><!--non fonctionnel-->
                    Date : <label>
                        <input type="date" name="date" value="">
                    </label><br>  <!--non fonctionnel-->
                    Lieu : <label>
                        <input type="text" name="lieu" value="">
                    </label><!--non fonctionnel-->
                    PrixMin : <label>
                        <input type="number" name="prixmin" min="0">
                    </label>
                    PrixMax : <label><input type="number" name="prixmax" min="0"></label>
                    <input type="submit" value="Rénitialiser">
                    <input type="submit" value="Rechercher">
                </form>
            </div>
            <table>
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>CashPrize</th>
                    <th>Notoriété</th>
                    <th>Lieu</th>
                    <th>Heure de début</th>
                    <th>Date</th>
                    <th>Fin Inscription</th>
                    <th>Jeu</th>
                    <th>Plus d'info</th>
                </tr>
                </thead>
                <tbody>
                <?php $listeTournois->afficherTournois(); ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>