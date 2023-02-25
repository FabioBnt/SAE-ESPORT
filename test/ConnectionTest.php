<?php 
declare(strict_types=1);
require_once(dirname(__DIR__) . '/model/Connection.php');
//create a test Connection
class ConnectionTest extends \PHPUnit\Framework\TestCase {
    private $user;
    //set up
    protected function setUp(): void {
        $this->user = Connection::getInstanceWithoutSession();
    } 
    //tear down
    protected function tearDown(): void {
        $this->user->disconnect();
    }
    //test
    public function testConnectionValidAdmin() {
        $this->user->establishConnection("admin", "\$iutinfo", Role::Administrator);
        $this->assertSame($this->user->getRole(), Role::Administrator);
    }
    //test
    public function testConnectionValidArbitre(){
        $this->user->establishConnection("arbitre", "\$iutinfo", Role::Arbitre);
        $this->assertSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnectionValidOrganization(){
        $this->user->establishConnection("KCorpEcurie", "motdepasseKCorp", Role::Organization);
        $this->assertSame($this->user->getRole(), Role::Organization);
    }
    //test
    public function testConnectionValidTeam(){
        $this->user->establishConnection("KCorpLoLEquipe", "mdpKcorplol", Role::Team);
        $this->assertSame($this->user->getRole(), Role::Team);
    }
    //test
    public function testConnectionIdInvalidAdmin(){
        $this->user->establishConnection("user", "\$iutinfo", Role::Administrator);
        $this->assertNotSame($this->user->getRole(), Role::Administrator);
    }
    //test
    public function testConnectionIdInvalidArbitre(){
        $this->user->establishConnection("user", "\$iutinfo", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnectionIdInvalidOrganization(){
        $this->user->establishConnection("user", "mdpKCorp", Role::Organization);
        $this->assertNotSame($this->user->getRole(), Role::Organization);
    }
    //test
    public function testConnectionIdInvalidTeam(){

        $this->user->establishConnection("user", "PasswordKcorplol", Role::Team);
        $this->assertNotSame($this->user->getRole(), Role::Team);
    }
    //test
    public function testConnectionMdpInvalidAdmin(){
        $this->user->establishConnection("admin", "motdepasse", Role::Administrator);
        $this->assertNotSame($this->user->getRole(), Role::Administrator);
    }
    //test
    public function testConnectionMdpInvalidArbitre(){
        $this->user->establishConnection("arbitre", "motdepasse", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnectionMdpInvalidOrganization(){
        $this->user->establishConnection("KCorpAdmin", "motdepasse", Role::Organization);
        $this->assertNotSame($this->user->getRole(), Role::Organization);
    }
    //test
    public function testConnectionMdpInvalidTeam(){
        $this->user->establishConnection("KCorpLoLCompte", "motdepasse", Role::Team);
        $this->assertNotSame($this->user->getRole(), Role::Team);
    }
    //test
    public function testConnectionIdMdpInvalidAdmin(){
        $this->user->establishConnection("user", "motdepasse", Role::Administrator);
        $this->assertNotSame($this->user->getRole(), Role::Administrator);
    }
    //test
    public function testConnectionIdMdpInvalidArbitre(){
        $this->user->establishConnection("user", "motdepasse", Role::Arbitre);
        $this->assertNotSame($this->user->getRole(), Role::Arbitre);
    }
    //test
    public function testConnectionIdMdpInvalidOrganization(){
        $this->user->establishConnection("user", "motdepasse", Role::Organization);
        $this->assertNotSame($this->user->getRole(), Role::Organization);
    }
    //test
    public function testConnectionIdMdpInvalidTeam(){

        $this->user->establishConnection("user", "motdepasse", Role::Team);
        $this->assertNotSame($this->user->getRole(), Role::Team);
    }
    //test
    public function testConnectionInvalidIdAdministrator(){
        $this->user->establishConnection("user", "\$iutinfo", Role::Administrator);
        $this->assertNotSame($this->user->getRole(),Role::Administrator);
    }
}
?>