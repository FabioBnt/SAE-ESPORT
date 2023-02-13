<?php
class Database {
    private static $instance = null;
    ///Connexion au serveur Mysql
    private $server = '145.14.156.192';
    private $login = 'u563109936_faisters';
    private $mdp = '1/4w[7z8fU';
    private $db = 'u563109936_esporters';
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
    //récupérer l'instance
    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    //récupérer le pdo de la database
    public function getPDO(): PDO
    {
        return $this->linkpdo;
    }
    //créer un select Mysql et renvoie le résultat
    public function select(string $cols, string $tables, string $conditions="")
    {
        $pdo = $this->getPDO();
        $query = "SELECT ".$cols." FROM ".$tables;
        if ($conditions) {
            $query .= " ".$conditions;
        }
        return $pdo->query($query)->fetchAll();
    }

    //créer un insert Mysql et renvoie le résultat
    public function Insert(string $table, int $num, array $values): void
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("INSERT INTO ".$table." VALUES (".str_repeat("?, ", $num-1).'?)');
        $stmt->execute($values);
    }
    //créer un select Mysql et renvoie le résultat par ligne
    public function selectL(string $cols, string $tables, string $conditions=""){
        $pdo = $this->getPDO();
        return $pdo->query("select ".$cols." from ".$tables." ".$conditions)->fetch(PDO::FETCH_ASSOC);
    }
}
?>