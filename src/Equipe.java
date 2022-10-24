import java.util.ArrayList;
import java.util.List;
import com.modeliosoft.modelio.javadesigner.annotations.objid;

@objid ("9499f272-2825-42d0-9d68-51f7fe5e30d6")
public class Equipe extends Utilisateur {
    @objid ("c71e73e4-8f67-4528-9c67-69348301290e")
    private String nom;

    @objid ("5a1b8caf-9f24-49b8-9288-c6bd8883dd30")
    private int points;

    @objid ("8fc9d538-a718-4991-871d-7fa648f778c3")
    private Ecurie ecurie;

    @objid ("d0bca616-d195-45cb-83ed-3bb9b27cf821")
    private Jeu jeu;

    @objid ("00ffcaa7-a65d-47d6-887c-fe084bb3cc33")
    public void inscrire(Tournoi tournoi) {
    }

    @objid ("47226d20-de55-4f89-b427-e033f0743752")
    public String toString() {
        return nom;
    }

    @objid ("3a1b3eec-585c-4d9f-a330-10dcc52f8dee")
    @Override
    public void seConnecter(String nom, String mdp) {
        // TODO Auto-generated method stub
    }

    @objid ("851dc512-bd67-441f-b99e-59a088847681")
    @Override
    public void deconnecter() {
        // TODO Auto-generated method stub
    }

}
