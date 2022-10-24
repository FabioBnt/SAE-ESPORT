package code;
import java.util.ArrayList;
import java.util.List;

public class Ecurie extends Connexion {
    public Ecurie(String identifiant, String mdp) {
		super(identifiant, mdp, Role.ECURIE);
		// TODO Auto-generated constructor stub
	}

	private String designation;

    private TypeEcurie type;

    private List<Equipe> equipes = new ArrayList<Equipe> ();
    
    public void creerEquipe(String nom, Joueur j1, Joueur j2, Joueur j3, Joueur j4) {
    }

    public List<Equipe> getEquipes() {
        return equipes;
    }

    public Equipe getEquipe(String nom) {
        return null;
    }

    public String toString() {
        return designation + type;
    }

    @Override
    public void deconnecter() {
        // TODO Auto-generated method stub
    }

}
