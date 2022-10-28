package code;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class ConnexionJDBC {
	public static Connection connecter() {
		String login = "BNF3924A";
		String mdpasse = "iutinfo";
		String connectString = "jdbc:oracle:telline.univ-tlse3.fr:1521:ETUPRE";
		
		try {
			DriverManager.registerDriver(new oracle.jdbc.OracleDriver());
		}catch (SQLException e) {
			e.printStackTrace();
			
		}
		
		try {
			Connection connx = DriverManager.getConnection(connectString, login, mdpasse);
			System.out.println("Connexion OK");
			return connx;
		}
		catch(Exception ee) {
			System.out.println("Erreur de connexion");
			ee.printStackTrace();
		}
		return null;
	}
}
