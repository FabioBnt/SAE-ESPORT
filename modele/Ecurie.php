<?php

include_once 'Connexion.php';

class Ecurie {
    private $designation;
    private $type;
    private $equipes = array();

    public function __construct($designation, $type, $equipes) {
        $this->designation = $designation;
        $this->type = $type;
        $this->equipes = $equipes;
    }
    public function creerEquipe($nom, $j1, $j2, $j3, $j4) {
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


}