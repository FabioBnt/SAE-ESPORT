import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import com.modeliosoft.modelio.javadesigner.annotations.objid;

@objid ("b94da7ab-8bc6-40b1-a3c7-c7decdd02cca")
public class Tournoi {
    @objid ("a9e08122-cae6-4075-9b4d-032d87d6ba26")
    private String nom;

    @objid ("56b796ea-6f19-4977-89ee-c2c02ade83ef")
    private float prix;

    @objid ("bef858a8-77a9-4966-ae92-754582bd7153")
    private TypeNotoriete notoriete;

    @objid ("505889f8-6da5-4815-826a-83bb9ee3c129")
    private String lieu;

    @objid ("6ad1101a-684a-4b5c-9083-4bea59bde9a4")
    private String heureDebut;

    @objid ("e4ef84c8-7cbb-493a-9d6c-b9610dd4780f")
    private Date date;

    @objid ("efd538d7-5789-404c-8089-e24d319853a3")
    private List<Poule> poules = new ArrayList<Poule> ();

    @objid ("789ffbc4-af3f-40ac-b6e1-404b20984912")
    private List<Jeu> jeu = new ArrayList<Jeu> ();

    @objid ("d5f0805c-4cad-49c1-aff3-9e22a72733c2")
    public Tournoi(String nom, String prix, TypeNotoriete notoriete, String lieu, String heureDebut, Date date) {
    }

    @objid ("ea8b8d69-0a76-41f4-a17e-857e4f68dc87")
    public String toString() {
        return heureDebut;
    }

    @objid ("6bf2a7fc-1c1f-41d8-bbfd-f147c6509a04")
    private void genererLesPoules() {
    }

    @objid ("ca4a72be-3f01-4cd7-a91e-9791c23f4722")
    public void genererPouleFinale() {
    }

    @objid ("360046c4-369d-4a8a-8452-dcc7248ad3be")
    private List<Equipe> meilleursEquipes() {
        return null;
    }

    @objid ("b346a490-1edd-4552-969b-d258724858e1")
    private void miseAJourDePoints() {
    }

}
