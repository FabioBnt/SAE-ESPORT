<?php
require_once ("../dao/OrganizationDAO.php");
//create an organization
class Organization {
    private string $designation;
    private string $type;
    private array $teams = array();
    private int $id;
    //constructor
    public function __construct($id,$designation,$type) {
        $this->designation = $designation;
        $this->type = $type;
        $this->id = $id;
    }
    //get teams of the organization
    public function getTeams() {
        return $this->teams;
    }
    // Create a team
    public function createTeam(string $name,string $accountName,string $password,int $idGame,int $idOrganization) {
        $mysql = new OrganizationDAO();
        $mysql->insertTeam($name,$accountName,$password,$idGame,$idOrganization);
    }
    // Retrieve organization's information
    public static function getOrganization($id): Organization
    {
        $Organization = null;
        $mysql = new OrganizationDAO();
        $dataE = $mysql->selectOrganization($id);
        foreach($dataE as $ligneE){
            $Organization = new Organization(null,$ligneE['Designation'],$ligneE['TypeE']);
        }
        return $Organization;
    }
    //get designation of the organization
    public function getDesignation()
    {
        return $this->designation;
    }
    //get type of the organization
    public function getType()
    {
        return $this->type;
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