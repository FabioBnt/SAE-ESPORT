<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once(dirname(__DIR__) . '/model/Connection.php');
//create a test Connection
class ConnectionTest extends TestCase {
    private Connection $user;
    //set up
    protected function setUp(): void {
        $this->user = Connection::getInstanceWithoutSession();
    } 
    //tear down
    protected function tearDown(): void {
        $this->user->disconnect();
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionValidAdmin(): void
    {
        $this->user->establishConnection('admin', "\$iutinfo", Role::Administrator);
        $this->assertSame($this->user->getRole(), Role::Administrator);
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionValidArbitre(): void
    {
        $this->user->establishConnection('arbitre', "\$iutinfo", Role::Arbitre);
        $this->assertSame($this->user->getRole(), Role::Arbitre);
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionValidOrganization(): void
    {
        $this->user->establishConnection('KCorpEcurie', 'motdepassekcorp', Role::Organization);
        $this->assertSame($this->user->getRole(), Role::Organization);
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionValidTeam(): void
    {
        $this->user->establishConnection('MenwizzTRLEquipe', 'mdpmenwizztrl', Role::Team);
        $this->assertSame($this->user->getRole(), Role::Team);
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionIdInvalidAdmin(): void
    {
        $this->user->establishConnection('user', "\$iutinfo", Role::Administrator);
        $this->assertNotSame(Role::Administrator, $this->user->getRole());
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionIdInvalidArbitre(): void
    {
        $this->user->establishConnection('user', "\$iutinfo", Role::Arbitre);
        $this->assertNotSame(Role::Arbitre, $this->user->getRole());
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionIdInvalidOrganization(): void
    {
        $this->user->establishConnection('user', 'mdpKCorp', Role::Organization);
        $this->assertNotSame(Role::Organization, $this->user->getRole());
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionIdInvalidTeam(): void
    {

        $this->user->establishConnection('user', 'PasswordKcorplol', Role::Team);
        $this->assertNotSame(Role::Team, $this->user->getRole());
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionMdpInvalidAdmin(): void
    {
        $this->user->establishConnection('admin', 'motdepasse', Role::Administrator);
        $this->assertNotSame(Role::Administrator, $this->user->getRole());
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionMdpInvalidArbitre(): void
    {
        $this->user->establishConnection('arbitre', 'motdepasse', Role::Arbitre);
        $this->assertNotSame(Role::Arbitre, $this->user->getRole());
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionMdpInvalidOrganization(): void
    {
        $this->user->establishConnection('KCorpAdmin', 'motdepasse', Role::Organization);
        $this->assertNotSame(Role::Organization, $this->user->getRole());
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionMdpInvalidTeam(): void
    {
        $this->user->establishConnection('KCorpLoLCompte', 'motdepasse', Role::Team);
        $this->assertNotSame(Role::Team, $this->user->getRole());
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionIdMdpInvalidAdmin(): void
    {
        $this->user->establishConnection('user', 'motdepasse', Role::Administrator);
        $this->assertNotSame(Role::Administrator, $this->user->getRole());
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionIdMdpInvalidArbitre(): void
    {
        $this->user->establishConnection('user', 'motdepasse', Role::Arbitre);
        $this->assertNotSame(Role::Arbitre, $this->user->getRole());
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionIdMdpInvalidOrganization(): void
    {
        $this->user->establishConnection('user', 'motdepasse', Role::Organization);
        $this->assertNotSame(Role::Organization, $this->user->getRole());
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionIdMdpInvalidTeam(): void
    {

        $this->user->establishConnection('user', 'motdepasse', Role::Team);
        $this->assertNotSame(Role::Team, $this->user->getRole());
    }
    //test

    /**
     * @throws Exception
     */
    public function testConnectionInvalidIdAdministrator(): void
    {
        $this->user->establishConnection('user', "\$iutinfo", Role::Administrator);
        $this->assertNotSame(Role::Administrator, $this->user->getRole());
    }
}
?>