import java.util.ArrayList;
import java.util.List;

public class Ecurie extends Utilisateur {
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

    public Ecurie(String designation, TypeEcurie type) {
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
