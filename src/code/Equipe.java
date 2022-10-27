package code;
import java.util.ArrayList;
import java.util.List;


public class Equipe extends Connexion {
    public Equipe(String identifiant, String mdp) {
		super(identifiant, mdp, Role.EQUIPE);
		// TODO Auto-generated constructor stub
	}

	private String nom;

    private int points;

    private Ecurie ecurie;

    private Jeu jeu;

    public void inscrire(Tournoi tournoi) {
    }

    public String toString() {
        return nom;
    }

    @Override
    public void deconnecter() {
        // TODO Auto-generated method stub
    }

}
