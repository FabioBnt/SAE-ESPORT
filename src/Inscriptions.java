import java.util.ArrayList;
import java.util.List;
import com.modeliosoft.modelio.javadesigner.annotations.objid;

@objid ("80d1da29-0825-4317-abb8-4683cb10b644")
public class Inscriptions {
    @objid ("bdc6aee6-1c3d-42f0-85c0-8d4d1ba5a6d5")
    private List<Equipe> equipes = new ArrayList<Equipe> ();

    @objid ("e84f98dc-b103-455f-a722-356e807ded46")
    private Tournoi tournoi;

    @objid ("78559ea5-5ff0-4214-9bbc-447abd2ef0da")
    private List<Inscriptions> inscriptions = new ArrayList<Inscriptions> ();

    @objid ("05e8aabf-a955-48c0-b5fe-c12edea7c916")
    private Inscriptions(Tournoi tournoi) {
    }

    @objid ("ae15747e-9589-463a-b42f-a8e453630cc1")
    public void ajouterEquipe(Equipe equipe) {
    }

    @objid ("5c01bd31-da0a-4577-a9e7-b5d3191f56c4")
    public List<Equipe> getEquipes() {
        return equipes;
    }

    @objid ("2d676ddb-617a-4e05-9b7e-f77d7d2cb3d4")
    public static Inscriptions getInstance(Tournoi tournoi) {
        return null;
    }

    @objid ("2239e718-0213-43cc-b870-48ca770e379e")
    public String toString() {
        return null;
    }

    @objid ("42100f2b-52b7-4ba5-a0a0-e7ec70c814e4")
    public Tournoi getTournoi() {
        return tournoi;
    }

}
