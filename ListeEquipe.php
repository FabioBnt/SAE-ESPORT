<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css" />
    <title>E-Sporter Manager</title>
</head>
<body class="listeEquipe">
    <!--Menu de navigation-->
    <header>
            <div class="menunav">
                <button class="buttonM" onclick="window.location.href='./index.php'">Accueil</button>
                <button class="buttonM" onclick="window.location.href='./ListeTournois.php'">Liste des Tournois</button>
                <button class="buttonM" onclick="window.location.href='./Classement.php'">Classement</button>
            </div>
            <div class="menucenter">
                <img class="logo" src="./img/logo header.png">
            </div>
            <div class="menuright">  
            <?php
                include './modele/Connexion.php';
                include './modele/Equipes.php';
                $connx = Connexion::getInstance();
                $listeEquipes = new Equipes();
                $listeEquipes->tousLesEquipes();
                if ($connx->getRole() == Role::Visiteur) {
                    echo '<a href="./ConnexionPage.php" id="connexion">Se Connecter</a>';
                } else {
                    echo '<div class="disconnect"><h3>Bonjour, ' . $connx->getIdentifiant() . '</h3>' . ' <a href="index.php?SeDeconnecter=true" id="deconnexion">Deconnexion</a></div>';
                }
            ?>
            </div>      
    </header>
    <main>
        <div class="listeEquipemain">
            <div class="divEquip1">
            <?php 
                if($connx->getRole() == Role::Ecurie){
                    echo "<a href='./CreerEquipe.php' class='buttonE' id='BtnCEquipe'>Créer Equipe</a>";
                };
            ?>
            </div>
            <?php
            if ($connx->getRole() == Role::Ecurie) {
                $identifiant = $connx->getIdentifiant();
                $mysql = Database::getInstance();
                $data = $mysql->selectL("E.IDEcurie,E.NomCompte",
                "Ecurie E", "where E.NomCompte ='".$identifiant."'");
                $id = $data['IDEcurie'];
                echo "<h1>Mes Equipes</h1>";
                echo "<div>";
                echo "<table id='TabEquipe'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th >Nom</th>";
                echo "<th >Jeu</th>";
                echo "<th >Plus dinformations</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                    $listeE = new Equipes();
                    $listeE ->selectEquipe("=".$id);
                    $listeE->afficherEquipesE();
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            }
            ?>
            <h1>Liste Des Equipes</h1>
            <div>
                <table id="TabEquipe">
                    <thead>
                        <tr>
                            <th >Nom</th>
                            <th >Ecurie</th>
                            <th >Jeu</th>
                            <th >Plus d'informations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $listeEquipes->afficherEquipes(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>