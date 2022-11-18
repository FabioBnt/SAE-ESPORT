<?php
include(dirname(__DIR__).'/modele/Connexion.php');
class ConnexionTest extends \PHPUnit\Framework\TestCase {
    public function testConnexionValideAdmin() {
        $user = Connexion::getInstance();
        $user->seConnecter("admin", "\$iutinfo", Role::Administrateur);
        $this->assertSame($user->getRole(), Role::Administrateur);
    }
}
?>