<?php 
declare(strict_types=1);
include_once(dirname(__DIR__) . '/model/Connexion.php');
//créer un test connexion
class ConnexionTest extends \PHPUnit\Framework\TestCase {
    private $user;
    //mettre en place
    protected function setUp(): void {
        $this->user = Connexion::getInstanceSansSession();
    } 
    //rénitialiser
    protected function tearDown(): void {
        $this->user->seDeconnecter();
    }
    //test
    public function testConnexionValideAdmin() {
        $this->user->seConnecter("admin", "\$iutinfo", Role::Administrateur);
        $this->assertSame($this->user->getRole(), Role::Administrateur);
    }
    //test
    public function testConnexionValideArbitre(){
        $this->user->seConnecter("arbitre", "\$iutinfo", Role::Arbitre);
        $this->assertSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnexionValideEcurie(){
        $this->user->seConnecter("KCorpAdmin", "mdpKCorp", Role::Ecurie);
        $this->assertSame($this->user->getRole(), Role::Ecurie);
    }
    //test
    public function testConnexionValideEquipe(){
        $this->user->seConnecter("KCorpLoLCompte", "PasswordKcorplol", Role::Equipe);
        $this->assertSame($this->user->getRole(), Role::Equipe);
    }
    //test
    public function testConnexionIdInvalideAdmin(){
        $this->user->seConnecter("user", "\$iutinfo", Role::Administrateur);
        $this->assertNotSame($this->user->getRole(), Role::Administrateur);
    }
    //test
    public function testConnexionIdInvalideArbitre(){
        $this->user->seConnecter("user", "\$iutinfo", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnexionIdInvalideEcurie(){
        $this->user->seConnecter("user", "mdpKCorp", Role::Ecurie);
        $this->assertNotSame($this->user->getRole(), Role::Ecurie);
    }
    //test
    public function testConnexionIdInvalideEquipe(){

        $this->user->seConnecter("user", "PasswordKcorplol", Role::Equipe);
        $this->assertNotSame($this->user->getRole(), Role::Equipe);
    }
    //test
    public function testConnexionMdpInvalideAdmin(){
        $this->user->seConnecter("admin", "motdepasse", Role::Administrateur);
        $this->assertNotSame($this->user->getRole(), Role::Administrateur);
    }
    //test
    public function testConnexionMdpInvalideArbitre(){
        $this->user->seConnecter("arbitre", "motdepasse", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnexionMdpInvalideEcurie(){
        $this->user->seConnecter("KCorpAdmin", "motdepasse", Role::Ecurie);
        $this->assertNotSame($this->user->getRole(), Role::Ecurie);
    }
    //test
    public function testConnexionMdpInvalideEquipe(){
        $this->user->seConnecter("KCorpLoLCompte", "motdepasse", Role::Equipe);
        $this->assertNotSame($this->user->getRole(), Role::Equipe);
    }
    //test
    public function testConnexionIdMdpInvalideAdmin(){
        $this->user->seConnecter("user", "motdepasse", Role::Administrateur);
        $this->assertNotSame($this->user->getRole(), Role::Administrateur);
    }
    //test
    public function testConnexionIdMdpInvalideArbitre(){
        $this->user->seConnecter("user", "motdepasse", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnexionIdMdpInvalideEcurie(){
        $this->user->seConnecter("user", "motdepasse", Role::Ecurie);
        $this->assertNotSame($this->user->getRole(), Role::Ecurie);
    }
    //test
    public function testConnexionIdMdpInvalideEquipe(){

        $this->user->seConnecter("user", "motdepasse", Role::Equipe);
        $this->assertNotSame($this->user->getRole(), Role::Equipe);
    }
    //test
    public function testConnexionNonValideIdAdministrateur(){
        $this->user->seConnecter("user", "\$iutinfo", Role::Administrateur);
        $this->assertNotSame($this->user->getRole(),Role::Administrateur);
    }
}
?>