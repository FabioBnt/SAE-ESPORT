<?php
include_once "Database.php";
//créer un jeu
class Jeu
{
    private int $id;
    private $nom;
    private $type;
    private $temps;
    private $limiteInscription;
    //constructeur
    function __construct($id, $nom, $type, $temps, $limiteInscription){
        $this->id = $id;
        $this->nom = $nom;
        $this->type = $type;
        $this->temps = $temps;
        $this->limiteInscription = date($limiteInscription);
    }
    //récupéré le nom
    public function getNom(){
        return $this->nom;
    }
    //récupéré l'id
    public function getId(){
        return $this->id;
    }
    //récupéré les infos d'un jeu
    public function toString()
    {
        return $this->nom . $this->type . $this->temps . strval($this->limiteInscription);
    }
    //récupéré tous les jeux
    public static function tousLesJeux()
    {
        $data = Database::getInstance()->select('*', 'Jeu');
        $jeux = array();
        foreach($data as $ligne){
            $jeux[] = new Jeu($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']);
        }
        return ($jeux);
    }
    //récupéré la date limite d'inscription
    public function getlimiteInscription(){
        return $this->limiteInscription;
    }
    //récupéré un jeu par son id
    public static function getJeuById($id):Jeu {
        $data = Database::getInstance()->select('*', 'Jeu', 'where IdJeu = '.$id);
        $jeu = new Jeu($data[0]['IdJeu'],$data[0]['NomJeu'], $data[0]['TypeJeu'], $data[0]['TempsDeJeu'], $data[0]['DateLimiteInscription']);
        return $jeu;
    }
    //récupéré les jeux par équipes pas créé
    public static function JeuEquipeNJ($id)
    {
        $data = Database::getInstance()->select("*","Jeu J"," where J.IDjeu not in (SELECT E.IdJeu FROM Equipe E WHERE E.IDEcurie='".$id."')");
        $jeux = array();
        foreach($data as $ligne){
            $jeux[] = new Jeu($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']);
        }
        return ($jeux);
    }
}
?>