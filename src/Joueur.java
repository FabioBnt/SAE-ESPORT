import com.modeliosoft.modelio.javadesigner.annotations.objid;

@objid ("378ae42d-6722-45c7-91b8-1d7371e68757")
public class Joueur {
    @objid ("b79cfcc0-a801-45d1-9d66-77deeb993a4c")
    private String pseudo;

    @objid ("e22ffa32-ff57-496f-bdf8-de86944af93a")
    private String nationalite;

    @objid ("8c6f0ec5-a111-46fe-9625-aa70d6ade52d")
    public Joueur(String pseudo, String nationalite) {
    }

    @objid ("657b4697-6215-4fe5-bbba-ff64c82e583b")
    public String toString() {
        return pseudo + nationalite;
    }

}
