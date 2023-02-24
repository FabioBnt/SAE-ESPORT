<?php
include_once 'Connexion.php';
require_once '../dao/OrganizationDAO.php';
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

    // Create a team
    public function createTeam(string $name,string $accountName,string $password, int $idGame, int $idOrganization) {
        $mysql = new OrganizationDAO();
        $mysql->insertTeam($name,$accountName,$password,$idGame,$idOrganization);
    }

    // Retrieve organization's information
    public static function getOrganization($id): ?Ecurie
    {
        $ecurie = null;
        $mysql = new OrganizationDAO();
        $dataE = $mysql->selectOrganization($id);
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

    // Retrieve the id of an organization by its account name
    public static function getIDbyAccountName($accountName) {
        $mysql = new OrganizationDAO();
        $data = $mysql->selectOrganizationID($accountName);
        return $data;
    }

    // Create a player
    public function createPlayer(string $username,string $nationality,string $teamID) {
        $mysql = new OrganizationDAO();
        $mysql->insertPlayer($username,$nationality,$teamID);
    }
}
?>