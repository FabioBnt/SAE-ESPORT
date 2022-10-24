package code;
import java.util.ArrayList;
import java.util.List;

public class Arbitre extends Connexion {
    public Arbitre(String identifiant, String mdp) {
		super(identifiant, mdp, Role.ARBITRE);
		// TODO Auto-generated constructor stub
	}

	private List<Match> matchs = new ArrayList<Match> ();

    public void saisirResultat(Match match, List<String> scores) {
    }

    @Override
    public void deconnecter() {
        // TODO Auto-generated method stub
    }

}
