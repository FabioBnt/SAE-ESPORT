package code;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

public class Tournoi {
    private String nom;

    private float prix;

    private TypeNotoriete notoriete;

    private String lieu;

    private String heureDebut;

    private Date date;

    private List<Poule> poules = new ArrayList<Poule> ();

    private List<Jeu> jeu = new ArrayList<Jeu> ();

    public Tournoi(String nom, String prix, TypeNotoriete notoriete, String lieu, String heureDebut, Date date) {
    }

    public String toString() {
        return heureDebut;
    }

    private void genererLesPoules() {
    }

    public void genererPouleFinale() {
    }

    private List<Equipe> meilleursEquipes() {
        return null;
    }

    private void miseAJourDePoints() {
    }

}
