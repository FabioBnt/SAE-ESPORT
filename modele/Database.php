<?php

class Database {
    private static $instance = null;
    ///Connexion au serveur Mysql
    private $server = 'sql926.main-hosting.eu';
    private $login = 'u563109936_faister';
    private $mdp = 'MM7pGf4JyJoJgxz9';
    private $db = 'u563109936_esporter';
    private $linkpdo;

    private function __construct() {
        try {
            $this->linkpdo = new PDO("mysql:host=$this->server;dbname=$this->db", $this->login, $this->mdp);
            }
            catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            }
    }
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    public function getPDO(){
        return $this->linkpdo;
    }
    public function select(string $cols, string $tables, string $conditions=""){
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("select ".$cols." from ".$tables." ".$conditions);
        $stmt->execute(); 
        $data = $stmt->fetchAll();
        return $data;
    }
    public function Insert(string $table, string $values){
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("INSERT INTO".$table." VALUES (".$values.")");
        $stmt->execute(); 
        $data = $stmt->fetchAll();
        return $data;
    }
}
?>