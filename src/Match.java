import java.util.ArrayList;
import java.util.Date;
import java.util.List;


public class Match {
    private Date date;

    private String heure;

    private int[] score = new int[2];

    private List<Equipe> equipe = new ArrayList<Equipe> ();

    public String toString() {
        return heure;
    }

    public void setScore(List<Integer> scores) {
    }

    public Match(Date date, String heure) {
    }

    public Equipe gagnant() {
        return null;
    }

}
