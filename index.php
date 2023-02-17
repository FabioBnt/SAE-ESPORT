<!--C moi le controleur-->
<!--parametre "page" pour recup qu'elle page on est-->
<?php
if(isset($_GET['page'])){
    $page=$_GET['page'];
    switch ($page) {
        case 'accueil':
            require('./vue/headervue.php');
            require('./vue/accueilvue.php');
            break;
        case 'listetournoi':
            require('./modele/Tournois.php');
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