
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
    if(isset($_GET['valide'])){
        echo '<script>alert("Score enregistré")</script>';
    }
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
        // if test = 2, on set les scores des matchs
        if($_GET['test'] == '2'){
            $poules = $t->getPoules()[$idJeu];
            foreach($poules as $p){
                $matchs = $p->getMatchs();
                $j = 0;
                foreach($matchs as $m){
                    // keys of teams
                    $keys = array_keys($m->getEquipes());
                    MatchJ::setScore($poules,$p->getId(),$keys[0],$keys[1],rand(0,$j+3),rand(0,$j+4));
                    $j++;
                    if ($j == 5) {
                        $poules = $t->getPoules()[$idJeu];
                    }
                }
            }
        }
        $listePoules = $t->getPoules();
        $nomTournoi = $t->getNom();
        $nomJeu = $t->getJeux()[$idJeu]->getNom();
        $pdo->rollBack();
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
<body class="score">
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
        <h1 id="labelS1">Score du Tournoi <?php echo (string)$nomTournoi.'<br>'. (string)$nomJeu ?> </h1>
        <?php 
            if($connx->getRole() == Role::Arbitre && isset($listePoules[$idJeu])){
                foreach($listePoules[$idJeu] as $poule){
                    if($poule->estPouleFinale() && !$poule->checkIfAllScoreSet()){
                        echo '<a href="SaisirScore.php?IDJ='.$idJeu.'&NomT='.$nomTournoi.'&JeuT='.$nomJeu.'" class="buttonE" id="ModifS7">Modification</a>';
                    }
                }
            }
            ?>
        <?php
        $i = 0;
        $pouleF = null;
        if(array_key_exists("$idJeu",$listePoules)){
            foreach ($listePoules[$idJeu] as $poule) {
                $i++;
                echo '<table id="tableS'.$i.'"><thead><tr><th colspan="4">Poule ';
                if($i==5){
                    echo'Finale';
                    $pouleF= $poule;
                }else{echo $i;};
                echo '</th></tr><tr><th>Equipe 1</th><th>Score</th><th>Equipe 2</th><th>Score</th></tr></thead><tbody>';
                foreach ($poule->getMatchs() as $match){
                    echo $match->afficherEquipes();
                }
                echo '</tbody></table>';
            }
        }else{
            echo '<h2 class=\'buttonE\' style=\'position: absolute; top: 85%; width: 80%; left: 50%;
            transform: translate(-55%, -60%);\'> Le tournoi n\'a pas encore commencé </h2>';
        }
        if($pouleF!=null){
            if($pouleF->checkIfAllScoreSet()){
                
        ?>
        <table id="tableS6">
            <thead>
                <tr>
                    <th>Classement</th>
                    <th>Place</th>
                </tr>
            </thead>
            <tbody>
                <?php
            $i = 0;
            if(array_key_exists("$idJeu",$listePoules)){
                foreach ($listePoules[$idJeu] as $poule) {
                    $i++;
                    if($i==5){
                        $p = $poule -> meilleuresEquipes();
                        $in=1;
                        foreach($p as $e){
                            echo "<tr>";
                            echo "<td>$in</td>";
                            echo "<td>";
                            echo $e->getNom();
                            echo "</td>";
                            echo "</tr>";
                            $in++;
                        }
                    }
                }
            }
            }
            }
            ?>
            </tbody>
        </table>
    </main>
</body>
</html>