<?php
require_once ("./dao/OrganizationDAO.php");
//create an organization
class Organization {
    private string $designation;
    private string $type;
    private array $teams = array();
    private int $id;
    private $dao;
    //constructor
    public function __construct(int $id,string $designation,string $type) {
        $this->designation = $designation;
        $this->type = $type;
        $this->id = $id;
        $this->dao=new OrganizationDAO();
    }
    //get teams of the organization
    public function getTeams():array {
        return $this->teams;
    }
    // Create a team
    public function createTeam(string $name,string $accountName,string $password,int $idGame,int $idOrganization):string {
        return $this->dao->insertTeam($name,$accountName,$password,$idGame,$idOrganization);
    }
    // Retrieve organization's information
    public static function getOrganization(int $id): Organization
    {
        $Organization = null;
        $dao=new OrganizationDAO();
        $dataE = $dao->selectOrganization($id);
        foreach($dataE as $ligneE){
            $Organization = new Organization($ligneE['IDEcurie'],$ligneE['Designation'],$ligneE['TypeE']);
        }
        return $Organization;
    }
    //get designation of the organization
    public function getDesignation():string
    {
        return $this->designation;
    }
    //get id of the organization
    public function getId():int
    {
        return $this->id;
    }
    //get type of the organization
    public function getType():string
    {
        return $this->type;
    }
    // Retrieve the id of an organization by its account name
    public static function getIDbyAccountName(string $accountName):int {
        $dao=new OrganizationDAO();
        $data = $dao->selectOrganizationID($accountName);
        return $data;
    }
    // Create a player
    public function createPlayer(string $username,string $nationality,string $teamID):string {
        return $this->dao->insertPlayer($username,$nationality,$teamID);
    }
}
?>