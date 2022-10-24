package code;
import java.util.List;


public class Jeu {
    private String nom;

    private TypeJeu type;

    private String temps;

    private int limiteInscription;

    public Jeu(String nom, float prix, TypeNotoriete notoriete, String heureDebut, String date) {
    }

    public String toString() {
        return nom + type + temps + limiteInscription;
    }

    public List<Jeu> tousLesJeux() {
        return null;
    }

}
