package code;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.Base64;
import java.util.LinkedList;
import java.util.Scanner;

public class JDBC {
	public static Connection connecter() {
		String login = "Qk5GMzkyNEE=";
		String mdpasse = "JGl1dGluZm8=";
		String connectString = "jdbc:oracle:telline.univ-tlse3.fr:1521:ETUPRE";
		
		try {
			DriverManager.registerDriver(new oracle.jdbc.OracleDriver());
		}catch (SQLException e) {
			e.printStackTrace();
			
		}
		
		try {
			String rLogin = new String(Base64.getDecoder().decode(login));
			String rmdp = new String(Base64.getDecoder().decode(mdpasse));
			Connection connx = DriverManager.getConnection(connectString, rLogin, rmdp);
			System.out.println("Connexion OK");
			return connx;
		}
		catch(Exception ee) {
			System.out.println("Erreur de connexion");
			ee.printStackTrace();
		}
		return null;
	}
	public static void saisirDonnéesDeTestConnexion() {
		Connection connx = JDBC.connecter();
		try {
			PreparedStatement ps = connx.prepareStatement("Insert into ? (ID, MDP) values(?,?,?)");
	        LinkedList<Object[]> list = new LinkedList<Object[]>();
	        list.add(new Object[]{"ECURIE",9991,"ecurie", "$iutinfo"});
	        list.add(new Object[]{"EQUIPE",9992,"equipe", "$iutinfo"});
	        for(Object[] o : list) {
	        	ps.setString(1, (String) o[0]);
	        	ps.setInt(2, (int) o[1]);
	        	ps.setString(3, (String) o[2]);
	        	ps.setString(4, (String) o[3]);
	        	ps.executeUpdate();
	        	ps.execute();
	        }
	        connx.commit();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}
	public static void retirerDonnéesDeTestConnexion() {
		Connection connx = JDBC.connecter();
		try {
			PreparedStatement ps = connx.prepareStatement("Delete from ? where ID = ?");
	        LinkedList<Object[]> list = new LinkedList<Object[]>();
	        list.add(new Object[]{"ECURIE",9991});
	        list.add(new Object[]{"EQUIPE",9992});
	        for(Object[] o : list) {
	        	ps.setString(1, (String) o[0]);
	        	ps.setInt(2, (int) o[1]);
	        	ps.executeUpdate();
	        	ps.execute();
	        }
	        connx.commit();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}
}
