import java.util.ArrayList;
import java.util.List;
import com.modeliosoft.modelio.javadesigner.annotations.objid;

@objid ("c1ec6b0b-f184-446b-ab59-c4fc82761249")
public class Arbitre extends Utilisateur {
    @objid ("13c57761-8fdb-4fd1-8e86-fd4256456570")
    private List<Match> matchs = new ArrayList<Match> ();

    @objid ("a662e90c-d83c-46db-af7f-57ee1514822b")
    public void saisirResultat(Match match, List<String> scores) {
    }

    @objid ("21a3da02-3efb-4fd9-adf9-c07a7221ac48")
    @Override
    public void seConnecter(String nom, String mdp) {
        // TODO Auto-generated method stub
    }

    @objid ("03a3bf45-570f-4c65-9805-88e01a57da26")
    @Override
    public void deconnecter() {
        // TODO Auto-generated method stub
    }

}
