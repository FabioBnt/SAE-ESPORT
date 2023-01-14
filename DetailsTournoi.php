<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include './modele/Connexion.php';
    include './modele/Tournois.php';
    $connx = Connexion::getInstance();
    $mysql = Database::getInstance();
    $listeTournois = new Tournois;
    $listeTournois->tousLesTournois();
    $idTournoi = $_GET['IDT'];
    $tournoi = $listeTournois->getTournoi($idTournoi);
    if(isset($_GET['inscrire'])){
        $idEquipe = $_GET['inscrire'];
        $equipe = Equipe::getEquipe($idEquipe);
        try{
            $equipe->inscrire($tournoi);
            echo '<script>alert("Inscription valide")</script>';
        }catch (Exception $e){
            echo '<script>alert("'.$e->getMessage().'")</script>';
        }

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
<body class="detailstournoi">
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
                        if($connx->getRole() === Role::Visiteur){
                            echo '<a href="./ConnexionPage.php" id="connexion">Se Connecter</a>';
                        }else{
                            echo '<div class="disconnect"><h3>Bonjour, '.$connx->getIdentifiant().'</h3>'.' <a href="index.php?SeDeconnecter=true" id="deconnexion">Deconnexion</a></div>';
                        }
                    ?>
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
                    <input id="Dgridi2" type="text" name="dateT" value='<?php echo $tournoi->getDate(); ?>' readonly>
                    <label id="Dgridl3"><b>Heure du tournoi</b></label>
                    <input id="Dgridi3" type="text" name="heureT" value='<?php echo $tournoi->getHeureDebut(); ?>' readonly>
                    <label id="Dgridl4"><b>Lieu du tournoi</b></label>
                    <input id="Dgridi4" type="text" name="lieuT" value='<?php echo $tournoi->getLieu(); ?>' readonly>
                    <label id="Dgridl5"><b>CashPrize</b></label>
                    <input id="Dgridi5" type="text" name="cashprizeT" value='<?php echo $tournoi->getCashPrize(); ?>' readonly>
                    <label id="Dgridl6"><b>Notoriété</b></label>
                    <input id="Dgridi6" type="text" name="notorieteT" value='<?php echo $tournoi->getNotoriete(); ?>' readonly>
                    <table id="Dgridt1">
                        <thead>
                            <tr>
                                <th >Jeu</th>
                                <th >Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tournoi->getJeux() as $jeu) {
                                echo '<tr><td>'.$jeu->getNom()."<td><a href='./Score.php?IDJ=".$jeu->getId().'&NomT='.$tournoi->getNom().'&JeuT='.$jeu->getNom()."'>+</a></td></tr>";
                                $_SESSION['jeu'.$jeu->getId()] = $tournoi->getPoules();
                            }
                            if(isset($_GET['IDJ'])){
                                header('Location:./Score.php?IDJ='.$_GET['IDJ'].'&NomT='.$_GET['NomT'].'&JeuT='.$_GET['JeuT'].'&valide');
                                exit();
                            }
                            ?>    
                        </tbody>
                    </table>
                    <?php
                        if(!isset($_GET['inscrire'])){
                            if($connx->getRole() == Role::Equipe){
                                $nomCompteEquipe = $connx->getIdentifiant();
                                $idEquipe = $mysql->select('E.IdEquipe','Equipe E','where E.NomCompte = '."'$nomCompteEquipe'");
                                $equipe = Equipe::getEquipe($idEquipe[0]['IdEquipe']);
                                if ($tournoi->contientJeu($equipe->getJeu())) {
                                    echo '<button class="buttonE" id="Dgrida1" onclick="confirmerInscription('.$idTournoi.', '. $idEquipe[0]['IdEquipe'].')">S\'inscrire</button>';
                                }
                            }
                        }
                    ?>
                    <!--<div id="data-equipe">
                        <?php /*echo htmlspecialchars($equipe); */?>
                    </div>-->
                    <table id="Dgridt2">
                        <thead>
                            <tr>
                                <th >Participant</th>
                                <th >Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tournoi->lesEquipesParticipants() as $participant) {
                                echo '<tr><td>'.$participant.'</td>';
                                echo "<td><a href='DetailsEquipe.php?IDE=".$participant->getId()."'>+</a></td></tr>";
                            } ?>
                        </tbody>
                    </table>
                    <a href="javascript:history.go(-1)" class="buttonE" id="Dgrida2">Retour</a>
                </div>
            </div>
        </div>
    </main>
    <script>
    function confirmerInscription(idt, ide){
    if (confirm("Êtes vous sûr de vouloir vous inscrire?")){
        window.location.assign("./DetailsTournoi.php?IDT=" + idt + "&inscrire=" + ide);
    }}</script>
</body>
</html>