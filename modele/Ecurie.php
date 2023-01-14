<?php
include_once 'Connexion.php';
include_once "Database.php";
//créer une écurie
class Ecurie {
    private $designation;
    private $type;
    private $equipes = array();
    private $id;
    //constructeur
    public function __construct($id,$designation, $type) {
        $this->designation = $designation;
        $this->type = $type;
        $this->id = $id;
    }
    //créer une équipe
    public function creerEquipe(string $nom, string $compte, string $mdp, int $jeu, int $ecurie) 
    {
        Database::getInstance()->insert("Equipe (NomE, NomCompte, MDPCompte, IdJeu , IDEcurie)", 5
         , array($nom, $compte, $mdp, $jeu, $ecurie));
    }
    //récupéré les équipes de l'écurie
    public function getEquipes() {
        return $this->equipes;
    }
    //récupéré les informations d'une écurie
    public static function getEcurie($id): ?Ecurie
    {
        $ecurie = null;
        $mysql = Database::getInstance();
        $dataE = $mysql->select('*', 'Ecurie e', 'where IdEcurie ='.$id);
        foreach($dataE as $ligneE){
            $ecurie = new Ecurie(null,$ligneE['Designation'],$ligneE['TypeE']);
        }
        return $ecurie;
    }
    /**
     * @return mixed
     */
    //récupéré la designation de l'écurie
    public function getDesignation()
    {
        return $this->designation;
    }
    //récupéré l'id de l'écurie par son nom de compte
    public static function getIDbyNomCompte($nomCompte) {
        $mysql = Database::getInstance();
        $data = $mysql->select("E.IDEcurie" , "Ecurie E" , "where E.NomCompte ="."'$nomCompte'");
        return $data[0]['IDEcurie'];
    }
    //ajouter un joueur
    public function ajouterJoueur(string $pseudo, string $nationalite, int $IdEquipe){
        Database::getInstance()->insert("Joueur (Pseudo, Nationalite, IdEquipe)", 3
         , array($pseudo, $nationalite, $IdEquipe));
    }
}
?>