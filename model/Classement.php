<?php
require_once('../dao/UserDAO.php');
include_once 'Jeu.php';
//creer un classement
class Classement
{
    private $jeu;
    public array $classement = array();
    //constructeur
    public function __construct($jeu){
        $this->jeu = $jeu;
    }
    //recuperer le jeu du classement
    public function getJeu(): Jeu
    {
        return $this->jeu;
    }
    //recuperer le classement
    public function getClassement(): array
    {
        return $this->classement;
    }
    //Retourner le classement du tournoi pour le jeu passé en paramètre
    public function returnRanking($idGame): void
    {
        $db = new UserDAO();
        $this->classement = array();
        $data = $db->selectRanking($idGame);
        foreach($data as $ligne){
            $this->classement[] = $ligne;
        }
    }
}
