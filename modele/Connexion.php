<?php
include 'Role.php';
class Connexion {
  private $role;
  private $identifiant;
  private static $instance = null;
  private const comptes = array();
  private function __construct() {
    $this->role = Role::Visiteur;
    $this->identifiant = "Guest";
    $this->comptes[Role::Administrateur] = ["admin", "\$iutinfo"];
    $this->comptes[Role::Arbitre] = ["arbitre", "\$iutinfo"];
    echo $this->comptes[Role::Arbitre][0];
    $this->comptes[Role::Arbitre][0] = "s";
    echo $this->comptes[Role::Arbitre][0];
  }
  public static function getInstance()
  {
    if (self::$instance == null)
    {
      self::$instance = new Connexion();
    }
    return self::$instance;
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
