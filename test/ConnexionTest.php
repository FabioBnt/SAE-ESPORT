<?php declare(strict_types=1);
include(dirname(__DIR__).'/modele/Connexion.php');
class ConnexionTest extends \PHPUnit\Framework\TestCase {

    private $user;
    protected function setUp(): void {
        $this->user = Connexion::getInstance();
    } 
    public static function setUpAfterClass(): void
    {
        Connexion::getInstance()->deConnecter();
    }

    protected function tearDown(): void {
        unset($this->user);
    }

    public function testConnexionValideAdmin() {
        $this->user->seConnecter("admin", "\$iutinfo", Role::Administrateur);
        $this->assertSame($this->user->getRole(), Role::Administrateur);
    }

    public function testConnexionValideArbitre(){
        $this->user->seConnecter("arbitre", "\$iutinfo", Role::Arbitre);
        $this->assertSame($this->user->getRole(), Role::Arbitre);
    }

    public function testConnexionValideEcurie(){
        $this->user->seConnecter("KCorpAdmin", "mdpKCorp", Role::Ecurie);
        $this->assertSame($this->user->getRole(), Role::Ecurie);
    }

    public function testConnexionValideEquipe(){
        $this->user->seConnecter("KCorpLoLCompte", "PasswordKcorplol", Role::Equipe);
        $this->assertSame($this->user->getRole(), Role::Equipe);
    }

    public function testConnexionIdInvalideAdmin(){
        $this->user->seConnecter("user", "\$iutinfo", Role::Administrateur);
        $this->assertNotSame($this->user->getRole(), Role::Administrateur);
    }

    public function testConnexionIdInvalideArbitre(){
        $this->user->seConnecter("user", "\$iutinfo", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }

    public function testConnexionIdInvalideEcurie(){
        $this->user->seConnecter("user", "mdpKCorp", Role::Ecurie);
        $this->assertNotSame($this->user->getRole(), Role::Ecurie);
    }
    
    public function testConnexionIdInvalideEquipe(){

        $this->user->seConnecter("user", "PasswordKcorplol", Role::Equipe);
        $this->assertNotSame($this->user->getRole(), Role::Equipe);
    }

    public function testConnexionMdpInvalideAdmin(){
        $this->user->seConnecter("admin", "motdepasse", Role::Administrateur);
        $this->assertNotSame($this->user->getRole(), Role::Administrateur);
    }

    public function testConnexionMdpInvalideArbitre(){
        $this->user->seConnecter("arbitre", "motdepasse", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }

    public function testConnexionMdpInvalideEcurie(){
        $this->user->seConnecter("KCorpAdmin", "motdepasse", Role::Ecurie);
        $this->assertNotSame($this->user->getRole(), Role::Ecurie);
    }
    
    public function testConnexionMdpInvalideEquipe(){
        $this->user->seConnecter("KCorpLoLCompte", "motdepasse", Role::Equipe);
        $this->assertNotSame($this->user->getRole(), Role::Equipe);
    }

    public function testConnexionIdMdpInvalideAdmin(){
        $this->user->seConnecter("user", "motdepasse", Role::Administrateur);
        $this->assertNotSame($this->user->getRole(), Role::Administrateur);
    }

    public function testConnexionIdMdpInvalideArbitre(){
        $this->user->seConnecter("user", "motdepasse", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }

    public function testConnexionIdMdpInvalideEcurie(){
        $this->user->seConnecter("user", "motdepasse", Role::Ecurie);
        $this->assertNotSame($this->user->getRole(), Role::Ecurie);
    }
    
    public function testConnexionIdMdpInvalideEquipe(){

        $this->user->seConnecter("user", "motdepasse", Role::Equipe);
        $this->assertNotSame($this->user->getRole(), Role::Equipe);
    }
}
?>