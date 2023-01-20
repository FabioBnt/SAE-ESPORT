
<?php
    include_once './modele/Administrateur.php';
    include_once './modele/Connexion.php';
    include_once './modele/Tournois.php';
    $connx = Connexion::getInstance();
    $mysql = Database::getInstance();
    $listePoules = null;
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
    if(isset($_GET['score1']) && isset($_GET['score2'])){
        try{
            MatchJ::setScore($listePoules[$idJeu],$_GET['poule'],$_GET['equipe1'], $_GET['equipe2'], $_GET['score1'],$_GET['score2']);
            $tournoi = new Tournois();
            $tournoi->tousLesTournois();
            $idT = MatchJ::getIdTournoi($_GET['poule']);
            //vers DetailsTournoi.php?IDT=
            header( 'Location:./DetailsTournoi.php?IDT='.$idT.'&IDJ='.$idJeu.'&NomT='.$nomTournoi.'&JeuT='.$nomJeu);
            exit();
        }catch(Exception $e){
            // redirect vers la page de SaissirScore.php
            header('Location:./SaisirScore.php?IDJ='.$idJeu.'&NomT='.$nomTournoi.'&JeuT='.$nomJeu.'&erreur='.$e->getMessage());
            exit();
        }

    }
    // si erreur
    if(isset($_GET['erreur'])){
        echo '<script>alert("'.$_GET['erreur'].'")</script>';
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
        <h1 id="labelS1">Saisie des scores du Tournoi <?php echo (string)$nomTournoi.'<br>'. (string)$nomJeu ?> </h1>
        <?php 
        if(array_key_exists("$idJeu",$listePoules)){
        ?>
        <table id='saisirscore'>
            <tr><td colspan="2">Saisie des scores</td></tr>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <div>
                <input type="hidden" name="NomT" value="<?php echo $nomTournoi;?>"/>
                <input type="hidden" name="JeuT" value="<?php echo $nomJeu;?>"/>
                <input type="hidden" name="IDJ" value="<?php echo $idJeu;?>"/>
                <tr>
                <td><label for="poule">Numéro de la Poule</label></td>
                <td>
                <select name="poule"  onchange='this.form.submit()'>
                    <option default value="">--- Choisir numéro de la poule ---</option>
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
                            if(isset($_GET['poule'])){
                                if($_GET['poule'] == $num){
                                    $temp = 'selected';
                                }
                            }
                            echo "<option ".$temp." value='".$poule->getNumero()."'>".$text."</option>";
                        }
                    ?>
                </select>
                </td>
                </tr>
                <noscript><input type="submit" value="Submit"></noscript>
            </div>
        </form>
        <?php if(isset($_GET['poule'])){ ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
            <div>
                <input type="hidden" name="NomT" value="<?php echo $nomTournoi;?>"/>
                <input type="hidden" name="JeuT" value="<?php echo $nomJeu;?>"/>
                <input type="hidden" name="IDJ" value="<?php echo $idJeu;?>"/>
                <input type="hidden" name="poule" value="<?php echo $_GET['poule'];?>"/>
                <?php
                 $equipe1 = null;
                 if(isset($_GET['equipe1'])){
                     $equipe1 = $_GET['equipe1'];
                 }
                $equipe2 = null;
                if(isset($_GET['equipe2'])){
                    $equipe2 = $_GET['equipe2'];
                    echo '<input type="hidden" name="equipe2" value="'.$equipe2.'"/>';
                }
                ?>
                <tr>
                <td><label for="equipe1">Equipe 1</label></td>
                <td>
                <select name="equipe1" id="poule" onchange='this.form.submit()'>
                    <option default value="">--- Choisir l'équipe ---</option>
                    <?php 
                        foreach ($listePoules[$idJeu] as $poule) { 
                            if($poule->getNumero() == $_GET['poule']){
                                foreach($poule->lesEquipes() as $equipe){
                                    $temp = '';
                                    if($equipe->getId() == $equipe1 ){
                                        $temp = 'selected';
                                    }
                                    if($equipe2 != $equipe->getId()){
                                        echo "<option ".$temp." value='".$equipe->getId()."'>".$equipe."</option>";
                                    }
                                }
                                break;
                            }
                        }
                    ?>
                </select>
                </td>
                </tr>
                <noscript><input type="submit" value="Submit"></noscript>
            </div>
        </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
            <div>
                <input type="hidden" name="NomT" value="<?php echo $nomTournoi;?>"/>
                <input type="hidden" name="JeuT" value="<?php echo $nomJeu;?>"/>
                <input type="hidden" name="IDJ" value="<?php echo $idJeu;?>"/>
                <input type="hidden" name="poule" value="<?php echo $_GET['poule'];?>"/>
                <?php
                $equipe1 = null;
                if(isset($_GET['equipe1'])){
                    $equipe1 = $_GET['equipe1'];
                    echo '<input type="hidden" name="equipe1" value="'.$equipe1.'"/>';
                }
                $equipe2 = null;
                if(isset($_GET['equipe2'])){
                    $equipe2 = $_GET['equipe2'];
                }
                ?>
                <tr>
                <td><label for="equipe2">Equipe 2</label></td>
                <td>
                <select name="equipe2" id="poule" onchange='this.form.submit()'>
                    <option default value="">--- Choisir l'équipe ---</option>
                    <?php 
                        foreach ($listePoules[$idJeu] as $poule) { 
                            if($poule->getNumero() === $_GET['poule']){
                                foreach($poule->lesEquipes() as $equipe){
                                    $temp = '';
                                    if($equipe->getId() == $equipe2 ){
                                        $temp = 'selected';
                                    }
                                    if($equipe1 != $equipe->getId()){
                                        echo "<option ".$temp." value='".$equipe->getId()."'>".$equipe."</option>";
                                    }
                                }
                                break;
                            }
                        }
                    ?>
                </select>
                </td>
                </tr>
                <noscript><input type="submit" value="Submit"></noscript>
            </div>
        </form>
        <?php if(isset($_GET['equipe1']) && isset($_GET['equipe2'])){ ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
            <div>
                <input type="hidden" name="NomT" value="<?php echo $nomTournoi;?>"/>
                <input type="hidden" name="JeuT" value="<?php echo $nomJeu;?>"/>
                <input type="hidden" name="IDJ" value="<?php echo $idJeu;?>"/>
                <input type="hidden" name="poule" value="<?php echo $poule->getId();;?>"/>
                <input type="hidden" name="equipe1" value="<?php echo $_GET['equipe1'];?>"/>
                <input type="hidden" name="equipe2" value="<?php echo $_GET['equipe2'];?>"/>
                <tr>
                    <td>Score équipe 1:</td>
                    <td><input type="number" name="score1" min="0" required></td>
                </tr>
                <tr>
                    <td>Score équipe 2:</td>
                    <td><input type="number" name="score2" min="0" required></td>
                </tr>
                <tr>
                <?php }?>
                    <a href="javascript:history.go(-1)" class="buttonE">Retour</a>
                    <?php if(isset($_GET['equipe1']) && isset($_GET['equipe2'])){ ?>
                    <input  class="buttonE" type="submit" value="Valider">
                </tr>
            </div>
        </form>
        <?php }} 
        }else{
            echo '<h2 class=\'buttonE\' style=\'position: absolute; top: 85%; width: 80%; left: 50%;
            transform: translate(-55%, -60%);\'> Le tournoi n\'a pas encore commencé </h2>';
        }
        ?>
    </main>
</body>
</html>