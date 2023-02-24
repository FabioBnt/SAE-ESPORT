<?php
require_once '../dao/UserDAO.php';
//créer un jeu
class Game
{
    private int $id;
    private $nom;
    private $type;
    private $temps;
    private $registerLimit;
    //constructeur
    public function __construct($id, $nom, $type, $temps, $limiteInscription){
        $this->id = $id;
        $this->nom = $nom;
        $this->type = $type;
        $this->temps = $temps;
        $this->registerLimit = date($limiteInscription);
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
        return $this->nom . $this->type . $this->temps . (string)$this->registerLimit;
    }
    //récupérer tous les jeux
    public static function allGames()
    {
        $data = new UserDAO();
        $data = $data->selectAllGames();
        $jeux = array();
        foreach($data as $ligne){
            $jeux[] = new Game($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']);
        }
        return ($jeux);
    }
    //récupérer la date limite d'inscription
    public function getRegisterLimit(){
        return $this->registerLimit;
    }
    //récupérer un jeu par son id
    public static function getJeuById($id):Game {
        $data = DAO::getInstance()->select('*', 'Game', 'where IdJeu = '.$id);
        $jeu = new Game($data[0]['IdJeu'],$data[0]['NomJeu'], $data[0]['TypeJeu'], $data[0]['TempsDeJeu'], $data[0]['DateLimiteInscription']);
        return $jeu;
    }
    //récupérer les jeux par équipes pas créé
    public static function JeuEquipeNJ($id)
    {
        $data = DAO::getInstance()->select("*","Game J"," where J.IDjeu not in (SELECT E.IdJeu FROM Equipe E WHERE E.IDEcurie='".$id."')");
        $jeux = array();
        foreach($data as $ligne){
            $jeux[] = new Game($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']);
        }
        return ($jeux);
    }
}
?>