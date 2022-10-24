import java.util.ArrayList;
import java.util.List;
import com.modeliosoft.modelio.javadesigner.annotations.objid;

@objid ("ece8e0f9-6c85-414e-9213-7dcd8da813fa")
public class Tournois {
    @objid ("8aa7bd74-bc96-48a7-97d9-6ca576f3b104")
    private List<Tournoi> tournois = new ArrayList<Tournoi> ();

    @objid ("64bd1c2a-6de9-464f-bc62-24ad31b68f2a")
    public List<Tournoi> tousLesTrournois() {
        return tournois;
    }

    @objid ("0e34ddbc-c275-43b8-8d4a-d5f15e6b1ac4")
    public List<Tournoi> tounoisDeJeu(Jeu jeu) {
        return tournois;
    }

    @objid ("60a26de2-97cc-4149-a067-a9abdcb8b50f")
    public List<Tournoi> tournoiDeNotoriete(TypeNotoriete notoriete) {
        return tournois;
    }

    @objid ("4d6d9260-b59a-42fd-a225-19155f6dc8e0")
    public List<Tournoi> tournoiAuraLieu(String lieu) {
        return tournois;
    }

    @objid ("605dbdfb-aff8-4ffd-813a-858819ac3ca6")
    public List<Tournoi> tournoiAvecPrixSuperieurA(float prix) {
        return tournois;
    }

    @objid ("66da4627-1bab-47b5-808d-3673e2f93955")
    public List<Tournoi> tournoiCommenceLe(String date) {
        return tournois;
    }

    @objid ("d44071ba-faca-4c1c-b27e-8fae6d0391cc")
    public String toString() {
        return null;
    }

}
