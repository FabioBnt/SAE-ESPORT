package code;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Base64;
import java.util.Collections;
import java.util.HashMap;
import java.util.Map;

public abstract class Connexion {
	private Role role;

	private String identifiant;

	private boolean connexion;

	public Connexion(String identifiant, String mdp, Role role) {
		// comptes uniques
		Map<Role, String[]> comptes = new HashMap<Role, String[]>();
		comptes.put(Role.ADMINISTRATEUR, new String[]{"admin", "JGl1dGluZm8="});
		comptes.put(Role.ARBITRE, new String[]{"arbitre", "JGl1dGluZm8="});
		comptes = Collections.unmodifiableMap(comptes);

		this.connexion = false;
		this.identifiant = identifiant;
		this.role = Role.VISITEUR;

		if (Role.ADMINISTRATEUR == role || Role.ARBITRE == role) {
			if (comptes.get(role)[0].equals(identifiant) &&
					comptes.get(role)[1].equals(Base64.getEncoder().encodeToString(mdp.getBytes()))) {
				this.connexion = true;
				this.role = role;
			}
		} else {
			Connection connx = JDBC.connecter();
			try {
				Statement st = connx.createStatement(ResultSet.TYPE_FORWARD_ONLY, ResultSet.CONCUR_READ_ONLY);
				ResultSet rs = st.executeQuery("select * from" + this.role + " where id = " + this.identifiant);
				String result = null;
				
				while (rs.next()) {
					result = rs.getString("mpd");
				}
				if (result != null) {
					if (Base64.getEncoder().encodeToString(mdp.getBytes()).equals(result)) {
						this.connexion = true;
						this.role = role;
					}
				}
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
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
