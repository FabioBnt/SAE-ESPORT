<?php
include_once "DAO.php";
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
    //récupérer le nom
    public function getNom(){
        return $this->nom;
    }
    //récupérer l'id
    public function getId(){
        return $this->id;
    }
    //récupérer les infos d'un jeu
    public function toString()
    {
        return $this->nom . $this->type . $this->temps . strval($this->limiteInscription);
    }
    //récupérer tous les jeux
    public static function tousLesJeux()
    {
        $data = DAO::getInstance()->select('*', 'Jeu');
        $jeux = array();
        foreach($data as $ligne){
            $jeux[] = new Jeu($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']);
        }
        return ($jeux);
    }
    //récupérer la date limite d'inscription
    public function getlimiteInscription(){
        return $this->limiteInscription;
    }
    //récupérer un jeu par son id
    public static function getJeuById($id):Jeu {
        $data = DAO::getInstance()->select('*', 'Jeu', 'where IdJeu = '.$id);
        $jeu = new Jeu($data[0]['IdJeu'],$data[0]['NomJeu'], $data[0]['TypeJeu'], $data[0]['TempsDeJeu'], $data[0]['DateLimiteInscription']);
        return $jeu;
    }
    //récupérer les jeux par équipes pas créé
    public static function JeuEquipeNJ($id)
    {
        $data = DAO::getInstance()->select("*","Jeu J"," where J.IDjeu not in (SELECT E.IdJeu FROM Equipe E WHERE E.IDEcurie='".$id."')");
        $jeux = array();
        foreach($data as $ligne){
            $jeux[] = new Jeu($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']);
        }
        return ($jeux);
    }
}
?>