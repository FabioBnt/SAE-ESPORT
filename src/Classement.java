import java.util.ArrayList;
import java.util.List;
import com.modeliosoft.modelio.javadesigner.annotations.objid;

@objid ("a1a98620-7a3e-43b4-b4bf-90ebf6ab21d0")
public class Classement {
    @objid ("8e9e1678-68bc-4c90-a0c3-f6c5fc5a6ed2")
    private Jeu jeu;

    @objid ("f3277402-9dc1-43ce-aa7f-958ee1621734")
    private List<Equipe> equipe = new ArrayList<Equipe> ();

    @objid ("f725fa1c-b1f8-409d-b49c-a57335122888")
    public List<Classement> classement = new ArrayList<Classement> ();

    @objid ("206dd2db-089d-4934-a123-8a8e885f2e17")
    private Classement(Jeu jeu) {
    }

    @objid ("810988db-e20e-415e-89ef-465e3085350c")
    public static Classement getInstance(Jeu jeu) {
        return null;
    }

    @objid ("7995e290-6f44-4e07-8dc4-8257a5601fc6")
    public String toString() {
        return null;
    }

}
