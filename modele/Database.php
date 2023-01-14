<?php
class Database {
    private static $instance = null;
    ///Connexion au serveur Mysql
    private $server = 'sql926.main-hosting.eu';
    private $login = 'u563109936_faister';
    private $mdp = 'MM7pGf4JyJoJgxz9';
    private $db = 'u563109936_esporter';
    private $linkpdo;
    //constructeur
    private function __construct() {
        try {
            $this->linkpdo = new PDO("mysql:host=$this->server;dbname=$this->db", $this->login, $this->mdp);
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    //récupéré l'instance
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    //récupéré le pdo de la database
    public function getPDO(){
        return $this->linkpdo;
    }
    //créé un select Mysql et renvoie le résultat
    public function select(string $cols, string $tables, string $conditions=""){
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("select ".$cols." from ".$tables." ".$conditions);
        $stmt->execute(); 
        $data = $stmt->fetchAll();
        return $data;
    }
    //créé un insert Mysql et renvoie le résultat
    public function Insert(string $table, int $num, array $values){
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("INSERT INTO ".$table." VALUES (".str_repeat("?, ", $num-1).'?)');
        $res = $stmt->execute($values);
    }
    //créé un select Mysql et renvoie le résultat par ligne
    public function selectL(string $cols, string $tables, string $conditions=""){
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("select ".$cols." from ".$tables." ".$conditions);
        $stmt->execute(); 
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
}
?>