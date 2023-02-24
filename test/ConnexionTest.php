<?php 
declare(strict_types=1);
include_once(dirname(__DIR__) . '/model/Connexion.php');
//créer un test connexion
class ConnexionTest extends \PHPUnit\Framework\TestCase {
    private $user;
    //mettre en place
    protected function setUp(): void {
        $this->user = Connexion::getInstanceWithoutSession();
    } 
    //rénitialiser
    protected function tearDown(): void {
        $this->user->disconnect();
    }
    //test
    public function testConnexionValideAdmin() {
        $this->user->establishConnection("admin", "\$iutinfo", Role::Administrateur);
        $this->assertSame($this->user->getRole(), Role::Administrateur);
    }
    //test
    public function testConnexionValideArbitre(){
        $this->user->establishConnection("arbitre", "\$iutinfo", Role::Arbitre);
        $this->assertSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnexionValideEcurie(){
        $this->user->establishConnection("KCorpAdmin", "mdpKCorp", Role::Ecurie);
        $this->assertSame($this->user->getRole(), Role::Ecurie);
    }
    //test
    public function testConnexionValideEquipe(){
        $this->user->establishConnection("KCorpLoLCompte", "PasswordKcorplol", Role::Equipe);
        $this->assertSame($this->user->getRole(), Role::Equipe);
    }
    //test
    public function testConnexionIdInvalideAdmin(){
        $this->user->establishConnection("user", "\$iutinfo", Role::Administrateur);
        $this->assertNotSame($this->user->getRole(), Role::Administrateur);
    }
    //test
    public function testConnexionIdInvalideArbitre(){
        $this->user->establishConnection("user", "\$iutinfo", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnexionIdInvalideEcurie(){
        $this->user->establishConnection("user", "mdpKCorp", Role::Ecurie);
        $this->assertNotSame($this->user->getRole(), Role::Ecurie);
    }
    //test
    public function testConnexionIdInvalideEquipe(){

        $this->user->establishConnection("user", "PasswordKcorplol", Role::Equipe);
        $this->assertNotSame($this->user->getRole(), Role::Equipe);
    }
    //test
    public function testConnexionMdpInvalideAdmin(){
        $this->user->establishConnection("admin", "motdepasse", Role::Administrateur);
        $this->assertNotSame($this->user->getRole(), Role::Administrateur);
    }
    //test
    public function testConnexionMdpInvalideArbitre(){
        $this->user->establishConnection("arbitre", "motdepasse", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnexionMdpInvalideEcurie(){
        $this->user->establishConnection("KCorpAdmin", "motdepasse", Role::Ecurie);
        $this->assertNotSame($this->user->getRole(), Role::Ecurie);
    }
    //test
    public function testConnexionMdpInvalideEquipe(){
        $this->user->establishConnection("KCorpLoLCompte", "motdepasse", Role::Equipe);
        $this->assertNotSame($this->user->getRole(), Role::Equipe);
    }
    //test
    public function testConnexionIdMdpInvalideAdmin(){
        $this->user->establishConnection("user", "motdepasse", Role::Administrateur);
        $this->assertNotSame($this->user->getRole(), Role::Administrateur);
    }
    //test
    public function testConnexionIdMdpInvalideArbitre(){
        $this->user->establishConnection("user", "motdepasse", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnexionIdMdpInvalideEcurie(){
        $this->user->establishConnection("user", "motdepasse", Role::Ecurie);
        $this->assertNotSame($this->user->getRole(), Role::Ecurie);
    }
    //test
    public function testConnexionIdMdpInvalideEquipe(){

        $this->user->establishConnection("user", "motdepasse", Role::Equipe);
        $this->assertNotSame($this->user->getRole(), Role::Equipe);
    }
    //test
    public function testConnexionNonValideIdAdministrateur(){
        $this->user->establishConnection("user", "\$iutinfo", Role::Administrateur);
        $this->assertNotSame($this->user->getRole(),Role::Administrateur);
    }
}
?>