<?php
require_once("./model/Role.php");
require_once("./dao/UserDAO.php");
//create a connection
class Connection
{
    private string $role;
    private string $identifiant;
    private static $instance = null;
    private array $accounts = array();
    //constructor
    private function __construct()
    {
        $this->role = Role::Visiteur;
        $this->identifiant = "Guest";
        $this->accounts[Role::Administrator] = ["admin", "\$iutinfo"];
        $this->accounts[Role::Arbitre] = ["arbitre", "\$iutinfo"];
    }
    //get instance of the Connection
        
    public static function getInstance()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION[self::class])) {
            self::$instance = new Connection();
            $_SESSION[self::class] = self::$instance;
        }
        return $_SESSION[self::class];
    }
    //connection session
    function establishConnection(string $id, string $password,string $role):void
    {
        if ($role == Role::Administrator || $role == Role::Arbitre) {
            if ($this->accounts[$role][0] == $id && $this->accounts[$role][1] == $password) {
                $this->role = $role;
                $this->identifiant = $id;
            }
        } else {
            $dao = new UserDAO();
            $data = $dao->connectToWebsite($id,$role);
            foreach ($data as $ligne) {
                if ($ligne['MDPCompte'] == $password) {
                    $this->role = $role;
                    $this->identifiant = $id;
                }
            }
        }
    }
    // get instance without session
    public static function getInstanceWithoutSession()
    {
        if (self::$instance == null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }
    // disconnect session
    public function disconnect():void
    {
        $this->role = Role::Visiteur;
        $this->identifiant = "Guest";
    }
    // if get role of the connection is the role param
    public function IfgetRoleConnection(string $role):bool
    {
        return ($this->getRole() == $role);
    }
    //get identifiant of the connection
    function getIdentifiant():string
    {
        return $this->identifiant;
    }
    //get role of the connection
    function getRole():string
    {
        return $this->role;
    }
}
?>