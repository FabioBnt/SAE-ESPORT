<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css" />
    <title>E-Sporter Manager</title>
</head>
<body class="equipeD">
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
                include './modele/Tournois.php';
                include './modele/Equipes.php';
                $connx = Connexion::getInstance();
                $mysql = Database::getInstance();
                $listeEquipes = new Equipes();
                $listeEquipes->tousLesEquipes();
                $idEquipe = $_GET['IDE'];
                $equipeT = $listeEquipes->getEquipe($idEquipe);
                $equipe = new Equipe($equipeT[0]['IdEquipe'],$equipeT[0]['NomE'],$equipeT[0]['NbPointsE'],$equipeT[0]['IDEcurie'],$equipeT[0]['IdJeu']);
                        if($connx->getRole() == Role::Visiteur){
                            echo '<a href="./ConnexionPage.php" id="connexion">Se Connecter</a>';
                        }else{
                            echo '<div class="disconnect"><h3>Bonjour, '.$connx->getIdentifiant().'</h3>'.' <a href="index.php?SeDeconnecter=true" id="deconnexion">Deconnexion</a></div>';
                        }
                    ?>
            </div>      
    </header>
    <main>
        <div class="detailsequipemain">
            <div class="Divdetails">
            <a href="javascript:history.go(-1)" class="buttonE">Retour</a>
                <h1>Details d'une équipe</h1>
                <div class="gridDetails">
                    <div id="EDgridl1">
                    <label ><b>Nom de l'équipe</b></label>
                    <input type="text" name="nameE" value='<?php echo $equipe->getNom(); ?>' readonly>
                    </div>
                    <div id="EDgridl2">
                    <label ><b>Nom du Jeu</b></label>
                    <input type="text" name="jeu" value='<?php 
                    $mysql = Database::getInstance();
                    $data = $mysql->selectL("J.NomJeu",
                    "Jeu J", "where J.IdJeu =".$equipe->getJeu().'');
                    echo $data['NomJeu'];
                    ?>' readonly>
                    </div>
                    <div id="EDgridl3">
                    <label><b>Nom de l'écurie</b></label>
                    <input type="text" name="ecurieE" value='<?php 
                    echo $equipe->getEcurie()
                    ?>' readonly>  
                    </div>
                    <div id="EDgridl5">
                    <label ><b>Nb Tournois Gagnés</b></label>
                    <?php echo $equipe->getNbmatchG(); ?>
                    <input type="text" name="nbtg" value='<?php echo $equipe->getNbmatchG(); ?>' readonly>
                    </div>
                    <div id="EDgridl6">
                    <label ><b>Gains Totaux</b></label>
                    <input type="text" name="gt" value='<?php echo "X"; ?>' readonly>
                    </div>
                    <div id="EDgridl7">
                    <label ><b>Nb Points</b></label>
                    <input type="text" name="nbp" value='<?php echo $equipe->getPoints(); ?>' readonly>
                    </div>
                    <div id="EDgridl4">
                    </div>
                    <table id="EDgridt1">
                        <thead>
                            <tr>
                                <th >Pseudo</th>
                                <th >Nationalité</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $mysql = Database::getInstance();
                            $data = $mysql->select("Pseudo,Nationalite",
                             "Joueur J", "where J.IdEquipe= ".$idEquipe."");
                             if($data==Null){
                                $i=0;
                                while($i<4){
                                echo"<tr>";
                                echo "<td>X</td>";
                                echo "<td>X</td>";
                                echo "</tr>";
                                $i++;
                                } ;
                            }else {
                                    $ii=0;
                                    foreach($data as $j){
                                        echo "<tr>";
                                        echo "<td>".$j[0]."</td>";
                                        echo "<td>".$j[1]."</td>";
                                        echo "</tr>";
                                        $ii++;
                                    };
                                    while($ii<4){
                                        echo"<tr>";
                                        echo "<td>X</td>";
                                        echo "<td>X</td>";
                                        echo "</tr>";
                                        $ii++;
                                    };
                                };
                            ?>
                        </tbody>
                    </table>
                </div>
                <table>
                <thead>
                <tr><th colspan="9">Liste des Tournois Participés</th></tr>    
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
                <?php 
                $listeTournois = new Tournois();
                $listeTournois->TournoisEquipe($idEquipe);
                $listeTournois->afficherTournois(); ?>

                </tbody>
            </table>
            </div>
        </div>
    </main>
</body>
</html>