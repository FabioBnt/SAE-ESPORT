<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once 'Database.php';
include_once 'Jeu.php';
include_once 'Equipe.php';
class Classement
{
    private $jeu;
    public $classement = array();

    function __construct($jeu){
        $this->jeu = $jeu;
    }

    public function getJeu()
    {
        return $this->jeu;
    }

    public function getClassement()
    {
        return $this->classement;
    }

    //Retourne le classement du tournoi pour le jeu passé en paramètre
    public function returnClassement($idJeu): void
    {
        $db = Database::getInstance();
        $this->classement = array();
        $data = $db->select('*','Equipe E','where E.IdJeu ='.$idJeu.' ORDER BY E.NbPointsE DESC');
        foreach($data as $ligne){
            $this->classement[] = $ligne;
        }
    }

    //Affiche le classement des équipes pour un jeu
    public function afficherClassement($idJeu): void
    {
        $jeu = Jeu::getJeuById($idJeu);
        $this->returnClassement(idJeu: ($jeu->getId()));
        $listeEquipes = $this->getClassement();
        foreach ($listeEquipes as $equipe) {
            $equipe = new Equipe($equipe['IdEquipe'], $equipe['NomE'], $equipe['NbPointsE'], $equipe['IDEcurie'], $equipe['IdJeu']);
            echo "<tr>";
            $infoEquipe = $equipe->listeInfoClassement();
            foreach ($infoEquipe as $colValue) {
                echo '<td>'.$colValue.'</td>';
            }
            // echo '<td>'.$i.$equipe['NomE'].' '.$equipe['NbPointsE'].'</td>';
            echo "<td><a href='./DetailsEquipe.php?IDE=".$equipe->getId()."'>+</a></td>";
            echo "</tr>";
        }
    }
    
    public static function getInstance($jeu)
    {
        return NULL;
    }
    public function toString()
    {
        return NULL;
    }
}
/*$jeu = new Jeu(1,'test','test',120,12);
 $apple = new Classement($jeu);
$apple->afficherClassement($jeu);*/
?>