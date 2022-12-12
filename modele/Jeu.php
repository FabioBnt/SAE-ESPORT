<?php
include_once "Database.php";
class Jeu
{
    private $id;
    private $nom;
    private $type;
    private $temps;
    private $limiteInscription;
    function __construct($id, $nom, $type, $temps, $limiteInscription){
        $this->id = $id;
        $this->nom = $nom;
        $this->type = $type;
        $this->temps = $temps;
        $this->limiteInscription = date($limiteInscription);
    }
    public function getNom(){
        return $this->nom;
    }

    public function getId(){
        return $this->id;
    }
    public function toString()
    {
        return $this->nom . $this->type . $this->temps . strval($this->limiteInscription);
    }
    public static function tousLesJeux()
    {
        $data = Database::getInstance()->select('*', 'Jeu');
        $jeux = array();
        foreach($data as $ligne){
            $jeux[] = new Jeu($ligne['IdJeu'],$ligne['NomJeu'], $ligne['TypeJeu'], $ligne['TempsDeJeu'], $ligne['DateLimiteInscription']);
        }
        return ($jeux);
    }
    public function getlimiteInscription(){
        return $this->limiteInscription;
    }
}

?>