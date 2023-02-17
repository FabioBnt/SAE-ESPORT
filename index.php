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
            require('./vue/headervue.php');
            require('');
            break;
        case 'classement':
            require('./vue/headervue.php');
            require('');
            break;
        case 'creerecurie':
            require('./vue/headervue.php');
            require('');
            break;
        case 'creerequipe':
            require('./vue/headervue.php');
            require('');
            break;
        case 'creertournoi':
            require('./vue/headervue.php');
            require('');
            break;
        case 'listeequipe':
            require('./vue/headervue.php');
            require('');
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