<?php
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
  function seConnecter() {
    if (Role.ADMINISTRATEUR == role || Role.ARBITRE == role) {
			if (comptes.get(role)[0].equals(identifiant) &&
					comptes.get(role)[1].equals(Base64.getEncoder().encodeToString(mdp.getBytes()))) {
				this.connexion = true;
				this.role = role;
			}
		} else {
      // id: BNF3924A mdp: iutinfo
			Connection connx = JDBC.connecter();
			try {
				Statement st = connx.createStatement(ResultSet.TYPE_FORWARD_ONLY, ResultSet.CONCUR_READ_ONLY);
				ResultSet rs = st.executeQuery("select * from" + this.role + " where id = " + this.identifiant);
				String result = null;
				
				while (rs.next()) {
					result = rs.getString("mpd");
				}
				if (result != null) {
					if (Base64.getEncoder().encodeToString(mdp.getBytes()).equals(result)) {
						this.connexion = true;
						this.role = role;
					}
				}
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
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
