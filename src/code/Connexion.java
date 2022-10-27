package code;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.HashMap;

public abstract class Connexion {
    private Role role;

    private String identifiant;
    
    private boolean connexion;
    
    private HashMap<String, String> comptes = new HashMap<String, String>();

    public Connexion(String identifiant, String mdp, Role role) {
    	comptes.put("admin", "Amosdr0m0FHmZV0uLtCqKg==");
    	comptes.put("arbitre", "Amosdr0m0FHmZV0uLtCqKg==");
    	this.identifiant = identifiant;
    	this.role = role;
    	Connection connx = ConnexionJDBC.connecter();
    	
    	try {
    		Statement st;
			st = connx.createStatement(ResultSet.TYPE_FORWARD_ONLY, ResultSet.CONCUR_READ_ONLY);
			ResultSet rs = st.executeQuery("select * from" + this.role + " where id = " + this.identifiant);
			
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
    	
    }

    public boolean estConnecter() {
		return connexion;
    }

    public abstract void deconnecter();

    public Role getRole() {
    	return this.role;
    }

    public String getIdentifiant() {
    	return this.identifiant;
    }
    
}
