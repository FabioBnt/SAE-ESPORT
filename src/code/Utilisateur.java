package code;
public abstract class Utilisateur {
    private boolean connexion;

    public abstract void seConnecter(String nom, String mdp);

    public abstract void deconnecter();

    public boolean estConnecter() {
		return connexion;
    }

}
