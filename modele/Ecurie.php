<?php

include_once 'Connexion.php';
include_once "Database.php";

class Ecurie {
    private $designation;
    private $type;
    private $equipes = array();
    private $id;

    public function __construct($id,$designation, $type, $equipes) {
        $this->designation = $designation;
        $this->type = $type;
        $this->equipes = $equipes;
        $this->id = $id;
    }
    public function creerEquipe(string $nom, string $compte, string $mdp, int $jeu, int $ecurie) 
    {
        Database::getInstance()->insert("Equipe (NomE, NomCompte, MDPCompte, IdJeu , IDEcurie)", 5
         , array($nom, $compte, $mdp, $jeu, $ecurie));
    }

    public function getEquipes() {
        return $this->equipes;
    }

    public function getEquipe($nom) {
        return null;
    }
    public static function getEcurie($id): ?Ecurie
    {
        $ecurie = null;
        $mysql = Database::getInstance();
        $dataE = $mysql->select('*', 'Ecurie e', 'where IdEcurie ='.$id);
        foreach($dataE as $ligneE){
            $ecurie = new Ecurie($ligneE['Designation'],$ligneE['TypeE'],null);
        }
        return $ecurie;
    }

    /**
     * @return mixed
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    public function getIDbyNomCompte($nomCompte) {
        $mysql = Database::getInstance();
        $data = $mysql-> select ("E.IDEcurie" , "Ecurie E" , "where E.NomCompteE =".$nomCompte);
        return $data[0]['IDEcurie'];
    }

}