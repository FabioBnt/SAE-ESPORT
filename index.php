<!--C moi le controleur-->
<!--parametre "page" pour recup qu'elle page on est-->
<?php
require ('./modele/Connexion.php');
require('./modele/Tournois.php');
if(isset($_GET['page'])){
    $page=$_GET['page'];
    switch ($page) {
        case 'accueil':
            require('./vue/headervue.php');
            require('./vue/accueilvue.php');
            break;
        case 'connexionvue':
            $connx = Connexion::getInstance();
            if(isset($_POST['username']) && isset($_POST['password'])){
                $connx->seConnecter($_POST['username'], $_POST['password'], $_POST['roles']);
                if($connx->getRole() == $_POST['roles']){
                    header("Location: ./index.php?page=accueil");
                }else{
                    header("Location: ./index.php?page=connexion&conn=1");
                }
            }
            require('./vue/connexionvue.php');
            break;
        case 'listetournoi':
            $Tournois = new Tournois();
            $liste=$Tournois->tousLesTournois();
            require('./vue/headervue.php');
            require('./vue/listetournoisvue.php');
            break;
        case 'classement':
            require('./vue/headervue.php');
            require('./vue/classementvue.php');
            break;
        case 'creerecurie':
            require('./vue/headervue.php');
            require('./vue/creerecurievue.php');
            break;
        case 'creerequipe':
            require('./vue/headervue.php');
            require('./vue/creerequipevue.php');
            break;
        case 'creertournoi':
            require('./vue/headervue.php');
            require('./vue/creertournoivue.php');
            break;
        case 'listeequipe':
            require('./vue/headervue.php');
            require('./vue/listeequipevue.php');
            break;
        case 'detailstournoi':
            require('./vue/headervue.php');
            require('./vue/detailstournoivue.php');
            break;
        case 'detailsequipe':
            require('./vue/headervue.php');
            require('./vue/detailsequipevue.php');
            break;
        case 'score':
            require('./vue/headervue.php');
            require('./vue/scorevue.php');
            break;
        default:
            require('./vue/headervue.php');
            require('./vue/accueilvue.php');
            break;
    }
} else {
    require('./vue/headervue.php');
    require('./vue/accueilvue.php');
}
?>