<?php

use phpDocumentor\Reflection\Types\Boolean;

include "Role.php";
include "Database.php";
class Connexion {
  private $role;
  private $identifiant;
  private static $instance = null;
  private $comptes = array();
  private function __construct() {
    $this->role = Role::Visiteur;
    $this->identifiant = "Guest";
    $this->comptes[Role::Administrateur] = ["admin", "\$iutinfo"];
    $this->comptes[Role::Arbitre] = ["arbitre", "\$iutinfo"];
  }
  public static function getInstance()
  {
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    if(!isset($_SESSION[self::class]))
    {
        self::$instance = new Connexion();
        $_SESSION[self::class] = self::$instance;
    }
    return $_SESSION[self::class];
  }
  function seConnecter(string $identifiant, string $password, $role) {
    if ($role == Role::Administrateur || $role == Role::Arbitre) {
			if ($this->comptes[$role][0] == $identifiant && $this->comptes[$role][1] == $password) {
				$this->role = $role;
        $this->identifiant = $identifiant;
			}
		} else {
      $mysql = Database::getInstance();
      $data = $mysql->select("MDPCompte", $role, "where NomCompte = '$identifiant'");
      foreach ($data as $ligne) {
          if ($ligne['MDPCompte'] == $password){
            $this->role = $role;
            $this->identifiant = $identifiant;
          }
      }
    }
  }
  public static function getInstanceSansSession(){
    if(self::$instance == null){
        self::$instance = new Connexion();
    }
    return self::$instance;
  }
  public function seDeconnecter(){
    $this->role = Role::Visiteur;
    $this->identifiant = "Guest";
  }

  public function estConnecterEnTantQue($role){
    if($this->getRole()== $role){
      return true;
    }
    return false;
  }

  function getIdentifiant() {
    return $this->identifiant;
  }
  function getRole() {
    return $this->role;
  }
}

?>
