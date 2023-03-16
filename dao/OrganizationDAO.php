<?php
require_once('./dao/DAO.php');
//create an organization dao class
class OrganizationDAO extends DAO
{
    private PDO $mysql;
    //constructor
    public function __construct() {
        $this->mysql= self::getInstance()->getConnection();
    }
    // Create a team in the database (Equipe table)
    public function insertTeam(string $name, string $accountName, string $accountPassword,int $idGame, int $idOrganization): string
    {
        $sql = "INSERT INTO Equipe (NomE, NomCompte, MDPCompte, NbPointsE, IdJeu, IDEcurie) VALUES ('$name','$accountName','$accountPassword',null,'$idGame','$idOrganization')";
            try {
                // Insert the team in the database (Equipe table)
                $stmt = $this->mysql->prepare($sql);
                return $stmt->execute();
            } catch (Exception $e) {
                $e->getMessage();
                return false;
            }
    }
    // Create a player in the database (Joueur table)
    public function insertPlayer(string $username, string $nationality, int $teamID):string
    {
        // Checks if the parameters are strings and integers
        if (is_string($username) && is_string($nationality) && is_int($teamID)) {
            // Makes sure to avoid sql injections
            $username = htmlspecialchars($username);
            $nationality = htmlspecialchars($nationality);
            try {
                // Insert the player in the database (Joueur table)
                $sql = 'INSERT INTO Joueur (Pseudo, Nationalite, IdEquipe) VALUES (:nom, :nationalite, :idEquipe)';
                $stmt = $this->mysql->prepare($sql);
                return $stmt->execute(
                    array(
                        ':nom' => $username,
                        ':nationalite' => $nationality,
                        ':idEquipe' => $teamID
                    )
                );
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return 0;
    }
    // Select an organization id by its account name
    public function selectOrganizationID(string $accountName)
    {
        $sql = "SELECT IdEcurie FROM Ecurie WHERE NomCompte ='$accountName'";
        try {
            // Select the organization id in the database (Equipe table)
            $stmt = $this->mysql->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result[0]['IdEcurie'];
        } catch (Exception $e) {
            throw new Exception('Error Processing Request select id ' .$e->getMessage(), 1);
        }
    }
    // Retrieve organization's information
    public function selectOrganization(int $id):array
    {
        $sql = "SELECT * FROM Ecurie WHERE IDEcurie = $id";
        try {
            $stmt = $this->mysql->prepare($sql);
            $id = 
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception('Error Processing Request select players ' .$e->getMessage(), 1);
        }
    }
}