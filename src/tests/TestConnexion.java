package tests;

import static org.junit.Assert.*;

import org.junit.After;
import org.junit.AfterClass;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;

import code.Administrateur;
import code.Arbitre;
import code.Ecurie;
import code.Equipe;
import code.JDBC;
import code.Role;

public class TestConnexion {
	@BeforeClass
    public static void setup() {
        JDBC.saisirDonnéesDeTestConnexion();
    }

    @AfterClass
    public static void tearDown() {
    	JDBC.retirerDonnéesDeTestConnexion();
    }

	@Test
	public void testConnextionAdministrateurValide() {
		Administrateur admin = new Administrateur("admin", "iutinfo");
		assertTrue(admin.estConnecter());
	}
	
	@Test
	public void testConnextionArbitreValide() {
		Arbitre arbitre = new Arbitre("arbitre", "iutinfo");
		assertTrue(arbitre.estConnecter());
	}
	
	@Test
	public void testConnextionEcurieValide() {
		Ecurie ecurie = new Ecurie("ecurie", "iutinfo");
		assertTrue(ecurie.estConnecter());
	}
	
	@Test
	public void testConnextionEquipeValide() {
		Equipe equipe = new Equipe("equipe", "iutinfo");
		assertTrue(equipe.estConnecter());
	}
	
	@Test
	public void testConnextionAdministrateurNonValideId() {
		Administrateur admin = new Administrateur("user", "iutinfo");
		assertFalse(admin.estConnecter());
	}
	
	@Test
	public void testConnextionArbitreNonValideId() {
		Arbitre arbitre = new Arbitre("user", "iutinfo");
		assertFalse(arbitre.estConnecter());
	}
	
	@Test
	public void testConnextionEcurieNonValideId() {
		Ecurie ecurie = new Ecurie("user", "iutinfo");
		assertFalse(ecurie.estConnecter());
	}
	
	@Test
	public void testConnextionEquipeNonValideId() {
		Equipe equipe = new Equipe("user", "iutinfo");
		assertFalse(equipe.estConnecter());
	}
	
	@Test
	public void testConnextionAdministrateurNonValideMdp() {
		Administrateur admin = new Administrateur("admin", "info");
		assertFalse(admin.estConnecter());
	}
	
	@Test
	public void testConnextionArbitreNonValideMdp() {
		Arbitre arbitre = new Arbitre("arbitre", "info");
		assertFalse(arbitre.estConnecter());
	}
	
	@Test
	public void testConnextionEcurieNonValideMdp() {
		Ecurie ecurie = new Ecurie("ecurie", "info");
		assertFalse(ecurie.estConnecter());
	}
	
	@Test
	public void testConnextionEquipeNonValideMdp() {
		Equipe equipe = new Equipe("equipe", "info");
		assertFalse(equipe.estConnecter());
	}
	@Test
	public void testConnextionAdministrateurNonValideIdMdp() {
		Administrateur admin = new Administrateur("user", "info");
		assertFalse(admin.estConnecter());
	}
	
	@Test
	public void testConnextionArbitreNonValideIdMdp() {
		Arbitre arbitre = new Arbitre("user", "info");
		assertFalse(arbitre.estConnecter());
	}
	
	@Test
	public void testConnextionEcurieNonValideIdMdp() {
		Ecurie ecurie = new Ecurie("user", "info");
		assertFalse(ecurie.estConnecter());
	}
	
	@Test
	public void testConnextionEquipeNonValideIdMdp() {
		Equipe equipe = new Equipe("user", "info");
		assertFalse(equipe.estConnecter());
	}
	

	@Test
	public void testConnextionAdministrateurNonValideIdArbitre() {
		Administrateur admin = new Administrateur("arbitre", "iutinfo");
		assertFalse(admin.estConnecter());
	}
	
	@Test
	public void testConnextionArbitreNonValideIdEcurie() {
		Arbitre arbitre = new Arbitre("ecurie", "iutinfo");
		assertFalse(arbitre.estConnecter());
	}
	
	@Test
	public void testConnextionEcurieNonValideIdEquipe() {
		Ecurie ecurie = new Ecurie("equipe", "iutinfo");
		assertFalse(ecurie.estConnecter());
	}
	
	@Test
	public void testConnextionEquipeNonValideIdAdmin() {
		Equipe equipe = new Equipe("admin", "iutinfo");
		assertFalse(equipe.estConnecter());
	}
	
	@Test
	public void testDeconnecter() {
		Administrateur admin = new Administrateur("admin", "iutinfo");
		admin.deconnecter();
		assertFalse(admin.estConnecter());
		assertEquals(Role.VISITEUR, admin.getRole());
		
		Arbitre arbitre = new Arbitre("arbitre", "iutinfo");
		arbitre.deconnecter();
		assertFalse(arbitre.estConnecter());
		assertEquals(Role.VISITEUR, arbitre.getRole());
		
		Ecurie ecurie = new Ecurie("equipe", "iutinfo");
		ecurie.deconnecter();
		assertFalse(ecurie.estConnecter());
		assertEquals(Role.VISITEUR, ecurie.getRole());
		
		Equipe equipe = new Equipe("admin", "iutinfo");
		equipe.deconnecter();
		assertFalse(equipe.estConnecter());
		assertEquals(Role.VISITEUR, equipe.getRole());
	}
	
	@Test
	public void testGetIdentifiant() {
		Administrateur admin = new Administrateur("admin", "iutinfo");
		assertEquals("admin", admin.getIdentifiant());
		
		Arbitre arbitre = new Arbitre("arbitre", "iutinfo");
		assertEquals("arbitre", arbitre.getIdentifiant());
		
		Ecurie ecurie = new Ecurie("ecurie", "iutinfo");
		assertEquals("ecurie", ecurie.getIdentifiant());
		
		Equipe equipe = new Equipe("equipe", "iutinfo");
		assertEquals(equipe, equipe.getIdentifiant());
	}
	
	@Test
	public void TestGetRole() {
		Administrateur admin = new Administrateur("admin", "iutinfo");
		assertEquals(Role.ADMINISTRATEUR, admin.getRole());
		
		Arbitre arbitre = new Arbitre("arbitre", "iutinfo");
		assertEquals(Role.ARBITRE, arbitre.getRole());
		
		Ecurie ecurie = new Ecurie("ecurie", "iutinfo");
		assertEquals(Role.ECURIE, ecurie.getRole());
		
		Equipe equipe = new Equipe("admin", "iutinfo");
		assertEquals(Role.EQUIPE, equipe.getRole());
	}
	
	
	

}
