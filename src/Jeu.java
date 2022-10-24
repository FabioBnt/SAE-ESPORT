import java.util.List;
import com.modeliosoft.modelio.javadesigner.annotations.objid;

@objid ("0c9de14d-2b43-4fad-a7af-a2d4350cf5ad")
public class Jeu {
    @objid ("58327d76-dd6c-45bc-bc37-ba8aa7797e42")
    private String nom;

    @objid ("486f072f-1349-45c1-aa77-a0dfa3713082")
    private TypeJeu type;

    @objid ("26ffd620-63e6-469e-b3fd-f730d2ed9bfe")
    private String temps;

    @objid ("866b135e-b31d-4b7a-aeba-1bba7e9c89a8")
    private int limiteInscription;

    @objid ("630fa359-690a-4061-bfee-68e5151c559b")
    public Jeu(String nom, float prix, TypeNotoriete notoriete, String heureDebut, String date) {
    }

    @objid ("69537cad-7d5b-4ab2-92b9-79f6497e402a")
    public String toString() {
        return nom + type + temps + limiteInscription;
    }

    @objid ("f4591e85-f3ab-412d-98ea-a7f4081dcc44")
    public List<Jeu> tousLesJeux() {
        return null;
    }

}
