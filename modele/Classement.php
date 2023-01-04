<?php
include './modele/Database.php';
class Classement
{
    private $jeu;
    private $equipes = array();
    public $classement = array();

    function __construct($jeu){
        $this->jeu = $jeu;
        $this->equipes = NULL;
        $this->classement = NULL;
    }

    public function getJeu()
    {
        return $this->jeu;
    }

    public function getEquipes()
    {
        return $this->equipes;
    }

    //Retourne le classement du tournoi pour le jeu passé en paramètre
    public function returnClassement($jeu){
        $db = Database::getInstance();
        $data = $db->select('SELECT * FROM ');
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

?>