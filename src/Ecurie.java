import java.util.ArrayList;
import java.util.List;
import com.modeliosoft.modelio.javadesigner.annotations.objid;

@objid ("9729f2ed-1fd8-4372-b5e5-5d96c534f457")
public class Ecurie extends Utilisateur {
    @objid ("aeeecc0c-6f83-4934-9126-51857ed180c5")
    private String designation;

    @objid ("6297b211-7109-4ba1-b248-d1155e0de29c")
    private TypeEcurie type;

    @objid ("b8bd6ad1-aad8-405f-a324-2c8cbf65ae4d")
    private List<Equipe> equipes = new ArrayList<Equipe> ();

    @objid ("68733824-f38d-4f33-b959-bf9d7e9fadc1")
    public void creerEquipe(String nom, Joueur j1, Joueur j2, Joueur j3, Joueur j4) {
    }

    @objid ("a8b2f01a-959a-459b-8814-14cfcc1c8af6")
    public List<Equipe> getEquipes() {
        return equipes;
    }

    @objid ("4201762d-5b25-4c9d-b139-840825b3695c")
    public Equipe getEquipe(String nom) {
        return null;
    }

    @objid ("4bc615e8-05a0-4d44-8206-5e88758d4ec3")
    public String toString() {
        return designation + type;
    }

    @objid ("1f5bb7a7-2316-4ca2-a82c-55e08134d9f7")
    public Ecurie(String designation, TypeEcurie type) {
    }

    @objid ("4d3b3d8a-b955-4cd9-bee3-3776741652fa")
    @Override
    public void seConnecter(String nom, String mdp) {
        // TODO Auto-generated method stub
    }

    @objid ("5b567186-5ef6-4848-adcc-5dd4e4d65cc0")
    @Override
    public void deconnecter() {
        // TODO Auto-generated method stub
    }

}
