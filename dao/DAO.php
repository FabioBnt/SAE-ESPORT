<?php
//create a dao class
class DAO {
    //login to Mysql server
    private $server = '145.14.156.192';
    private $login = 'u563109936_faisters';
    private $mdp = '1/4w[7z8fU';
    private $db = 'u563109936_esporters';
    private $connectionDB;
    //constructor
    protected function __construct() {
        try {
            $this->connectionDB = new PDO("mysql:host=$this->server;dbname=$this->db", $this->login, $this->mdp);
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    //retrieve the database pdo
    protected function getConnection(): PDO
    {
        return $this->connectionDB;
    }
}