<?php

class Oracle {
    private static $instance = null;
    ///Connexion au serveur Oracle
    private $server = "telline.univ-tlse3.fr:1521";
    private $db = "ETUPRE";
    private $login = "BNF3924A";
    private $mdp = "iutinfo";
    private $linkpdo;

    private function __construct() {
        try {
            $this->linkpdo = new PDO("oci:host=$this->server;dbname=$this->db", $this->login, $this->mdp);
            echo "Connexion réussie";
            }
            catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            }
    }
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Oracle();
        }
        return self::$instance;
    }
    public function getLinkPDO(){
        return $this->linkpdo;
    }
}
echo "Amogus ";
$app = Oracle::getInstance();
echo $app->getLinkPDO();

?>