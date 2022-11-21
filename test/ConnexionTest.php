<?php
include(dirname(__DIR__).'/modele/Connexion.php');
class ConnexionTest extends \PHPUnit\Framework\TestCase {
    public function testConnexionValideAdmin() {
        $user = Connexion::getInstance();
        $user->seConnecter("admin", "\$iutinfo", Role::Administrateur);
        $this->assertSame($user->getRole(), Role::Administrateur);
    }

    public function testConnexionValideArbitre(){
        $user = Connexion::getInstance();
        $user->seConnecter("arbitre", "\$iutinfo", Role::Arbitre);
        $this->assertSame($user->getRole(), Role::Arbitre);
    }

    public function testConnexionValideEcurie(){
        $user = Connexion::getInstance();
        $user->seConnecter("KCorpAdmin", "mdpKCorp", Role::Ecurie);
        $this->assertSame($user->getRole(), Role::Ecurie);
    }

    public function testConnexionValideEquipe(){
        $user = Connexion::getInstance();
        $user->seConnecter("KCorpLoLCompte", "PasswordKcorplol", Role::Equipe);
        $this->assertSame($user->getRole(), Role::Equipe);
    }
}
?>