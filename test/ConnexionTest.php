<?php 
declare(strict_types=1);
include_once(dirname(__DIR__) . '/model/Connection.php');
//créer un test Connection
class ConnectionTest extends \PHPUnit\Framework\TestCase {
    private $user;
    //mettre en place
    protected function setUp(): void {
        $this->user = Connection::getInstanceWithoutSession();
    } 
    //rénitialiser
    protected function tearDown(): void {
        $this->user->disconnect();
    }
    //test
    public function testConnectionValideAdmin() {
        $this->user->establishConnection("admin", "\$iutinfo", Role::Administrator);
        $this->assertSame($this->user->getRole(), Role::Administrator);
    }
    //test
    public function testConnectionValideArbitre(){
        $this->user->establishConnection("arbitre", "\$iutinfo", Role::Arbitre);
        $this->assertSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnectionValideOrganization(){
        $this->user->establishConnection("KCorpAdmin", "mdpKCorp", Role::Organization);
        $this->assertSame($this->user->getRole(), Role::Organization);
    }
    //test
    public function testConnectionValideEquipe(){
        $this->user->establishConnection("KCorpLoLCompte", "PasswordKcorplol", Role::Equipe);
        $this->assertSame($this->user->getRole(), Role::Equipe);
    }
    //test
    public function testConnectionIdInvalideAdmin(){
        $this->user->establishConnection("user", "\$iutinfo", Role::Administrator);
        $this->assertNotSame($this->user->getRole(), Role::Administrator);
    }
    //test
    public function testConnectionIdInvalideArbitre(){
        $this->user->establishConnection("user", "\$iutinfo", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnectionIdInvalideOrganization(){
        $this->user->establishConnection("user", "mdpKCorp", Role::Organization);
        $this->assertNotSame($this->user->getRole(), Role::Organization);
    }
    //test
    public function testConnectionIdInvalideEquipe(){

        $this->user->establishConnection("user", "PasswordKcorplol", Role::Equipe);
        $this->assertNotSame($this->user->getRole(), Role::Equipe);
    }
    //test
    public function testConnectionMdpInvalideAdmin(){
        $this->user->establishConnection("admin", "motdepasse", Role::Administrator);
        $this->assertNotSame($this->user->getRole(), Role::Administrator);
    }
    //test
    public function testConnectionMdpInvalideArbitre(){
        $this->user->establishConnection("arbitre", "motdepasse", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnectionMdpInvalideOrganization(){
        $this->user->establishConnection("KCorpAdmin", "motdepasse", Role::Organization);
        $this->assertNotSame($this->user->getRole(), Role::Organization);
    }
    //test
    public function testConnectionMdpInvalideEquipe(){
        $this->user->establishConnection("KCorpLoLCompte", "motdepasse", Role::Equipe);
        $this->assertNotSame($this->user->getRole(), Role::Equipe);
    }
    //test
    public function testConnectionIdMdpInvalideAdmin(){
        $this->user->establishConnection("user", "motdepasse", Role::Administrator);
        $this->assertNotSame($this->user->getRole(), Role::Administrator);
    }
    //test
    public function testConnectionIdMdpInvalideArbitre(){
        $this->user->establishConnection("user", "motdepasse", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnectionIdMdpInvalideOrganization(){
        $this->user->establishConnection("user", "motdepasse", Role::Organization);
        $this->assertNotSame($this->user->getRole(), Role::Organization);
    }
    //test
    public function testConnectionIdMdpInvalideEquipe(){

        $this->user->establishConnection("user", "motdepasse", Role::Equipe);
        $this->assertNotSame($this->user->getRole(), Role::Equipe);
    }
    //test
    public function testConnectionNonValideIdAdministrator(){
        $this->user->establishConnection("user", "\$iutinfo", Role::Administrator);
        $this->assertNotSame($this->user->getRole(),Role::Administrator);
    }
}
?>