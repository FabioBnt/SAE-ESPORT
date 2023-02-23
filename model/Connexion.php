<?php
use phpDocumentor\Reflection\Types\Boolean;
include "Role.php";
include_once "DAO.php";
//creer une connexion
class Connexion
{
    private $role;
    private $identifiant;
    private static $instance = null;
    private $comptes = array();
    //constructeur
    private function __construct()
    {
        $this->role = Role::Visiteur;
        $this->identifiant = "Guest";
        $this->comptes[Role::Administrateur] = ["admin", "\$iutinfo"];
        $this->comptes[Role::Arbitre] = ["arbitre", "\$iutinfo"];
    }
    //recuperer l'instance de la connexion
    public static function getInstance()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION[self::class])) {
            self::$instance = new Connexion();
            $_SESSION[self::class] = self::$instance;
        }
        return $_SESSION[self::class];
    }
    /**
     * @param string $identifiant
     * @param string $password
     * @param $role
     * @return void
     */
    //se connecter
    function seConnecter(string $identifiant, string $password, $role)
    {
        if ($role == Role::Administrateur || $role == Role::Arbitre) {
            if ($this->comptes[$role][0] == $identifiant && $this->comptes[$role][1] == $password) {
                $this->role = $role;
                $this->identifiant = $identifiant;
            }
        } else {
            $mysql = DAO::getInstance();
            $data = $mysql->select("MDPCompte", $role, "where NomCompte = '$identifiant'");
            foreach ($data as $ligne) {
                if ($ligne['MDPCompte'] == $password) {
                    $this->role = $role;
                    $this->identifiant = $identifiant;
                }
            }
        }
    }
    // recuperer l'instance sans avoir de session
    public static function getInstanceSansSession()
    {
        if (self::$instance == null) {
            self::$instance = new Connexion();
        }
        return self::$instance;
    }
    // se deconnecter
    public function seDeconnecter()
    {
        $this->role = Role::Visiteur;
        $this->identifiant = "Guest";
    }
    // savoir le rôle de la connexion
    public function estConnecterEnTantQue($role)
    {
        return ($this->getRole() == $role);
        
    }
    //récupérer l'identifiant de la connexion
    function getIdentifiant()
    {
        return $this->identifiant;
    }
    //récupérer le rôle de la connexion
    function getRole()
    {
        return $this->role;
    }
}
?>
