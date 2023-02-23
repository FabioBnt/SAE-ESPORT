<?php
class DAO {
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
    //récupérer le pdo de la database
    private function getPDO(): PDO
    {
        return $this->linkpdo;
    }
}
