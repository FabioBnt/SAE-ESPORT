<?php
require_once("./dao/DAO.php");
//create an organization dao class
class OrganizationDAO extends DAO
{
    //constructor
    public function __construct()
    {
        parent::__construct();
    }
    // Create a team in the database (Equipe table)
    public function insertTeam(string $name, string $accountName, string $accountPassword,int $idGame, int $idOrganization): string
    {
        // Checks if the parameters are strings
        if (is_string($name) && is_string($accountName) && is_string($accountPassword)) {
            // Makes sure to avoid sql injections
            $name = htmlspecialchars($name);
            $accountName = htmlspecialchars($accountName);
            $accountPassword = htmlspecialchars($accountPassword);
            try {
                $connection = parent::getConnection();
                // Insert the team in the database (Equipe table)
                $sql = "INSERT INTO Equipe (NomEquipe, NomCompte, MDPCompte,NbPointsE,IdJeu,IDEcurie) VALUES (:nom, :compte, :mdp,null,:idJeu,:idEcurie)";
                $stmt = $connection->prepare($sql);
                return $stmt->execute(
                    array(
                        ':nom' => $name,
                        ':compte' => $accountName,
                        ':mdp' => $accountPassword,
                        ':idJeu' => $idGame,
                        ':idEcurie' => $idOrganization
                    )
                );
            } catch (Exception $e) {
                $e->getMessage();
                return false;
            }
        }
        return false;
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
                $connection = parent::getConnection();
                // Insert the player in the database (Joueur table)
                $sql = "INSERT INTO Joueur (Pseudo, Nationalite, IdEquipe) VALUES (:nom, :nationalite, :idEquipe)";
                $stmt = $connection->prepare($sql);
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
    public function selectOrganizationID(string $accountName): int
    {
        // Checks if the parameter is a string
        if (is_string($accountName)) {
            // Makes sure to avoid sql injections
            $accountName = htmlspecialchars($accountName);
            try {
                $connection = parent::getConnection();
                // Select the organization id in the database (Equipe table)
                $sql = "SELECT IdEquipe FROM Equipe WHERE NomCompte = :compte";
                $stmt = $connection->prepare($sql);
                $stmt->execute(
                    array(
                        ':compte' => $accountName
                    )
                );
                $result = $stmt->fetch();
                return $result['IdEquipe'];
            } catch (Exception $e) {
                throw new Exception("Error Processing Request select id ".$e->getMessage(), 1);
            }
        }
        return 0;
    }
    // Retrieve organization's information
    public static function selectOrganization(int $id):array
    {
        $sql = "SELECT * FROM Ecurie WHERE IDEcurie = :id";
        try {
            $mysql = parent::getConnection();
            $stmt = $mysql->prepare($sql);
            $id = 
            $stmt->execute(
                array(
                    ':id' => $id
                )
            );
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error Processing Request select players ".$e->getMessage(), 1);
        }
    }
}