import java.util.ArrayList;
import java.util.List;
import com.modeliosoft.modelio.javadesigner.annotations.objid;

@objid ("7572901c-10d2-4dae-969e-764d42ecae1a")
public class Poule {
    @objid ("ca11293d-41cc-4f79-8221-3d5673e976c0")
    private String numero;

    @objid ("5d96de69-c6a7-42a6-8642-628eb0157d39")
    private List<Match> matchs = new ArrayList<Match> ();

    @objid ("ac11522a-2bcd-4e06-a624-9a62d4c2008d")
    public Poule(int numero, List<Match> matchs) {
    }

    @objid ("2db31c29-e17b-4ed7-ba06-220cc30e529d")
    public void mellieurEquipe() {
    }

    @objid ("40c96ee8-0bc5-44c9-b56d-90f0350160a8")
    private int nbMatchsGange(Equipe equipe) {
        return 0;
    }

}
