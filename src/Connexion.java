import com.modeliosoft.modelio.javadesigner.annotations.objid;

@objid ("3055b4a1-c530-40e1-904b-eb4e07375161")
public abstract class Connexion {
    @objid ("49f036e5-7658-4eb7-a505-b6b69a3d7627")
    private Role role;

    @objid ("6ef1582f-45b6-48d7-9dc8-a7c56d33e6e8")
    private String identifiant;

    @objid ("5aa635dc-7770-4af3-a446-5e1701b050a8")
    public Connexion(String identifiant, String mdp, Role role) {
    	this.identifiant = identifiant;
    	this.role = role;
    }

    @objid ("d31b26be-8c99-4cd5-bb1e-77b2a57143b6")
    public abstract void deconnecter();

    @objid ("bb4b3d35-1a56-4ce7-85fb-7515be2a6617")
    public Role getRole() {
    	return this.role;
    }

    @objid ("68c76bd7-99fb-4999-83e6-8cfc7e573d60")
    public String getIdentifiant() {
    	return this.identifiant;
    }

}
