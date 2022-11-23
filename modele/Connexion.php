<?php
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
    if (self::$instance == null)
    {
      self::$instance = new Connexion();
    }
    return self::$instance;
  }
  function seConnecter(string $identifiant, string $password, $role) {
    if ($role == Role::Administrateur || $role == Role::Arbitre) {
			if ($this->comptes[$role][0] == $identifiant && $this->comptes[$role][1] == $password) {
				$this->role = $role;
        $this->identifiant = $identifiant;
			}
		} else {
      $mysql = Database::getInstance();
      $pdo = $mysql->getPDO();
      $stmt = $pdo->prepare("select MDPCompte from ".$role." where NomCompte = :id");
      $stmt->execute(['id'=> $identifiant]); 
      $data = $stmt->fetchAll();
      // and somewhere later:
      foreach ($data as $row) {
          if ($row['MDPCompte'] == $password){
            $this->role = $role;
            $this->identifiant = $identifiant;
          }
      }
    }
  }
  function getIdentifiant() {
    return $this->identifiant;
  }
  function getRole() {
    return $this->role;
  }
}

$apple = Connexion::getInstance();
echo $apple->getIdentifiant();
echo "<br>";
echo $apple->getRole();
?>
