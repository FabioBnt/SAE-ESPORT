import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import com.modeliosoft.modelio.javadesigner.annotations.objid;

@objid ("c6978128-20e6-43c3-8765-85fdca4ab600")
public class Match {
    @objid ("53770bc3-dc59-4d57-bdd4-83e56b41684e")
    private Date date;

    @objid ("a090cfc7-b529-442a-b6de-291d61586235")
    private String heure;

    @objid ("30894eb9-6f94-45a7-a483-f3a9b06a1985")
    private int[] score = new int[2];

    @objid ("53621087-dd8f-41e6-87d3-dfcdf825f15a")
    private List<Equipe> equipe = new ArrayList<Equipe> ();

    @objid ("c7016512-365c-4a0d-bb95-d4669aaa97b7")
    public String toString() {
        return heure;
    }

    @objid ("64c9e4dd-8f75-4e61-96cb-9034054e4a8b")
    public void setScore(List<Integer> scores) {
    }

    @objid ("6a916ae5-39e3-40f3-b01e-93e72875ca6e")
    public Match(Date date, String heure) {
    }

    @objid ("1542e72b-89e3-4367-8638-efed842e2cfc")
    public Equipe gagnant() {
        return null;
    }

}
