import java.util.ArrayList;
import java.util.List;


public class Equipe extends Utilisateur {
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
    public void seConnecter(String nom, String mdp) {
        // TODO Auto-generated method stub
    }

    @Override
    public void deconnecter() {
        // TODO Auto-generated method stub
    }

}
