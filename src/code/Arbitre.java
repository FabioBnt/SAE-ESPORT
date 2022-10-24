package code;
import java.util.ArrayList;
import java.util.List;

public class Arbitre extends Utilisateur {
    private List<Match> matchs = new ArrayList<Match> ();

    public void saisirResultat(Match match, List<String> scores) {
    }

    @Override
    public void seConnecter(String nom, String mdp) {
        // TODO Auto-generated method stub
    }

    @Override
    public void deconnecter() {
        // TODO Auto-generated method stub
    }

}
