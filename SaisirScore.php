﻿
<?php
include_once './modele/Administrateur.php';
include_once './modele/Connexion.php';
include_once './modele/Tournois.php';
$connx = Connexion::getInstance();
$mysql = Database::getInstance();
$listePoules = null;
$listePoules;
$nomTournoi = null;
$nomJeu = null;
$idJeu = null;
if(isset($_GET['IDJ'])){
    $listePoules = $_SESSION['jeu'.$_GET['IDJ']];
    $nomTournoi = $_GET['NomT'];
    $nomJeu = $_GET['JeuT'];
    $idJeu = $_GET['IDJ'];
}else{
    $listePoules = array();
    $nomTournoi = "Inconnu";
    $nomJeu = 'Jeu Inconnu';
    $idJeu = null;
}
if(isset($_GET['test'])){
    Connexion::getInstanceSansSession()->seConnecter('admin','$iutinfo',Role::Administrateur);
    $tournoi = new Tournois();
    $pdo = Database::getInstance()->getPDO();
    $pdo->beginTransaction();
    $idJeu = 8;
    $admin = new Administrateur();
    $admin->creerTournoi('test',100,'Local','Toulouse','15:00','25/01/2023',array($idJeu));
    $id = $mysql->select('IdTournoi','Tournois','where NomTournoi = "test"');
    $tournoi->tousLesTournois();
    $t = $tournoi->getTournoi($id[0]['IdTournoi']);
    Connexion::getInstanceSansSession()->seConnecter('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
    $idE = $mysql->select('IdEquipe','Equipe','where IdJeu = '.$idJeu);
    $i = 0;
    $maxE = 16;
    if($_GET['test'] === '1'){
        $maxE = 14;
    }
    while($i < $maxE){
        $equipe = Equipe::getEquipe($idE[$i]['IdEquipe']);
        $equipe->Inscrire($t);
        $i++;
    }
    if($_GET['test'] === '1'){
        $t->genererLesPoules($idJeu);
    }
    $listePoules = $t->getPoules();
    $nomTournoi = $t->getNom();
    $nomJeu = $t->getJeux()[$idJeu]->getNom();
    $pdo->rollBack();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
<body class="score">
    <!--Menu de navigation-->
    <header>
            <div class="menunav">
                <button class="buttonM" onclick="window.location.href='./index.php'">Home</button>
                <button class="buttonM" onclick="window.location.href='./ListeTournois.php'">Liste des Tournois</button>
                <button class="buttonM" onclick="window.location.href='./Classement.php'">Classement</button>
            </div>

            <div class="menucenter">
                <img class="logo" src="./img/logo header.png">
            </div>

            <div class="menuright">  
                    <?php 
                        if($connx->getRole() == Role::Visiteur){
                            echo '<a href="./ConnexionPage.php" id="connexion">Se Connecter</a>';
                        }else{
                            echo '<div class="disconnect"><h3>Bonjour, '.$connx->getIdentifiant().'</h3>'.' <a href="index.php?SeDeconnecter=true" id="deconnexion">Deconnexion</a></div>';
                        }
                    ?>
            </div>      
    </header>
    <main class="scoredetails">
        <a href="javascript:history.go(-1)" class="buttonE" id="RetourS8">Retour</a>
        <h1 id="labelS1">Saisir Scores du Tournoi <?php echo (string)$nomTournoi.'<br>'. (string)$nomJeu ?> </h1>
        <a href="#" class="buttonE" id="ModifS7">Modification</a>
        <?php 
        if(array_key_exists("$idJeu",$listePoules)){
        ?>
        <form action=<?php echo 'SaisirScore.php?IDJ='.$idJeu.'&NomT='.$nomTournoi.'&JeuT='.$nomJeu.'&poule='.$_post["poule"];?> method="post">
            <div>
                <label for="poule">Numero Poule</label>
                <select name="poule" id="poule" onchange='this.form.submit()'>
                    <option default value="">--- Chosir numero de poule ---</option>
                    <?php 
                        foreach ($listePoules[$idJeu] as $poule) {
                            $text = "";
                            $num = $poule->getNumero();
                            if($poule->estPouleFinale()){
                                $text = "Finale";
                            }else{
                                $text = $num;
                            }
                            $temp = '';
                            if(isset($_post['poule'])){
                                if($_post['poule'] == $num){
                                    $temp = 'selected';
                                }
                            }
                            echo "<option ".$temp." value='".$poule->getNumero()."'>".$text."</option>";
                        }
                    ?>
                </select>
                <noscript><input type="submit" value="Submit"></noscript>
            </div>
        </form>
        <form action="#" method="get">
            <div>
                <label for="poule">Equipe1</label>
                <select name="poule" id="poule" onchange='this.form.submit()'>
                    <option default value="">--- Chosir numero de poule ---</option>
                    <?php 
                        foreach ($listePoules[$idJeu] as $poule) {
                            $text = "";
                            $num = $poule->getNumero();
                            if($poule->estPouleFinale()){
                                $text = "Finale";
                            }else{
                                $text = $num;
                            }
                            $temp = '';
                            echo "<option value='".$poule->getNumero()."'>".$text."</option>";
                        }
                    ?>
                </select>
                <noscript><input type="submit" value="Submit"></noscript>
            </div>
        </form>
        <form action="#" method="get">
            <div>
                <label for="poule">score equipe1 </label>
                <select name="poule" id="poule" onchange='this.form.submit()'>
                    <option default value="">--- Chosir numero de poule ---</option>
                    <?php 
                        foreach ($listePoules[$idJeu] as $poule) {
                            $text = "";
                            $num = $poule->getNumero();
                            if($poule->estPouleFinale()){
                                $text = "Finale";
                            }else{
                                $text = $num;
                            }
                            echo "<option value='".$poule->getNumero()."'>".$text."</option>";
                        }
                    ?>
                </select>
                <noscript><input type="submit" value="Submit"></noscript>
            </div>
        </form>
        <!---
        $i = 0;
        
            foreach ($listePoules[$idJeu] as $poule) {
                $i++;
                echo '<table id="tableS'.$i.'"><thead><tr><th colspan="4">Poule ';
                if($i==5){echo'Finale';}else{echo $i;};
                echo '</th></tr><tr><th>Equipe 1</th><th>Score</th><th>Equipe 2</th><th>Score</th></tr></thead><tbody>';
                foreach ($poule->getMatchs() as $match){
                    echo $match->afficherEquipes();
                }
                echo '</tbody></table>';
            }
        ?>--->
        <?php
        }else{
            echo '<h2 class=\'buttonE\' style=\'position: absolute; top: 85%; width: 80%; left: 50%;
            transform: translate(-55%, -60%);\'> Le trounoi n\'a pas encore commencé </h2>';
        }
        ?>
    </main>
</body>
</html>