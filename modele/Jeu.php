<?php
class Jeu
{
    private $nom;
    private $type;
    private $temps;
    private $limiteInscription;
    function __construct($nom, $type, $temps, $limiteInscription){
        $this->nom = $nom;
        $this->type = $type;
        $this->temps = $temps;
        $this->limiteInscription = $limiteInscription;
    }
    public function toString()
    {
        return $this->nom . $this->type . $this->temps . strval($this->limiteInscription);
    }
    public static function tousLesJeux()
    {
        return NULL;
    }
}

?>