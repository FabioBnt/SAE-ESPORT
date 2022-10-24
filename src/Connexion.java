public abstract class Connexion {
    private Role role;

    private String identifiant;

    public Connexion(String identifiant, String mdp, Role role) {
    	this.identifiant = identifiant;
    	this.role = role;
    }

    public abstract void deconnecter();

    public Role getRole() {
    	return this.role;
    }

    public String getIdentifiant() {
    	return this.identifiant;
    }

}
