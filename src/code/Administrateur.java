package code;
public class Administrateur extends Connexion {
    public Administrateur(String identifiant, String mdp) {
		super(identifiant, mdp, Role.ADMINISTRATEUR);
		// TODO Auto-generated constructor stub
	}

	public void creerTournoi() {
    }

    public void creerEcurie() {
    }

    @Override
    public void deconnecter() {
        // TODO Auto-generated method stub
    }

}
