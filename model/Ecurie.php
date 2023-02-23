<?php
include_once 'Connexion.php';
include_once "DAO.php";
//créer une écurie
class Ecurie {
    private $designation;
    private $type;
    private $equipes = array();
    private $id;
    //constructeur
    public function __construct($id,$designation, $type) {
        $this->designation = $designation;
        $this->type = $type;
        $this->id = $id;
    }
    
    //récupérer les équipes de l'écurie
    public function getEquipes() {
        return $this->equipes;
    }
    //récupérer les informations d'une écurie
    public static function getEcurie($id): ?Ecurie
    {
        $ecurie = null;
        $mysql = DAO::getInstance();
        $dataE = $mysql->select('*', 'Ecurie e', 'where IdEcurie ='.$id);
        foreach($dataE as $ligneE){
            $ecurie = new Ecurie(null,$ligneE['Designation'],$ligneE['TypeE']);
        }
        return $ecurie;
    }
    /**
     * @return mixed
     */
    //récupérer la designation de l'écurie
    public function getDesignation()
    {
        return $this->designation;
    }
    //récupérer l'id de l'écurie par son nom de compte
    public static function getIDbyNomCompte($nomCompte) {
        $mysql = DAO::getInstance();
        $data = $mysql->select("E.IDEcurie" , "Ecurie E" , "where E.NomCompte ="."'$nomCompte'");
        return $data[0]['IDEcurie'];
    }
}
?>