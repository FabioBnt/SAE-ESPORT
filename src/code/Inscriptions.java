package code;
import java.util.ArrayList;
import java.util.List;


public class Inscriptions {
    private List<Equipe> equipes = new ArrayList<Equipe> ();

    private Tournoi tournoi;

    private List<Inscriptions> inscriptions = new ArrayList<Inscriptions> ();

    private Inscriptions(Tournoi tournoi) {
    }

    public void ajouterEquipe(Equipe equipe) {
    }

    public List<Equipe> getEquipes() {
        return equipes;
    }

    public static Inscriptions getInstance(Tournoi tournoi) {
        return null;
    }

    public String toString() {
        return null;
    }

    public Tournoi getTournoi() {
        return tournoi;
    }

}
