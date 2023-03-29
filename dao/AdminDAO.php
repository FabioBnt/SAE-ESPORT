<?php
require_once('./dao/DAO.php');
//create an admin class for dao
class AdminDAO extends DAO
{
    private PDO $mysql;
    //constructor
    public function __construct() {
        $this->mysql= self::getInstance()->getConnection();
    }
    // Insert an organization in the database (Ecurie table)
    public function insertOrganization(string $name, string $account, string $pwd, string $type) :string
    {
        try {
            $sql = 'INSERT INTO Ecurie (Designation, TypeE, NomCompte, MDPCompte) VALUES (:nom, :type, :compte, :mdp)';
            return $this->mysql->prepare($sql)->execute(array(
                ':nom' => $name,
                ':type' => $type,
                ':compte' => $account,
                ':mdp' => $pwd
            ));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    // Create a tournament in the database (Tournois table)
    public function insertTournament(string $name, int $cashPrize, string $notoriety, string $city, string $startingHour, string $date, array $games): string
    {
        $sql = "INSERT INTO Tournois (NomTournoi, CashPrize, Notoriete, Lieu, DateHeureTournois) VALUES ('$name','$cashPrize','$notoriety','$city','$date $startingHour:00')";
        try {
            // Insert the tournament in the database (Tournois table)
            $stmt = $this->mysql->prepare($sql);
            $stmt->execute();
            // Get the id of the tournament
            $idTournament = $this->mysql->lastInsertId();
            // Insert the games in the database (Contenir table)
            foreach ($games as $game) {
                $sql = "INSERT INTO Contenir (IdJeu, IdTournoi) VALUES ('$game','$idTournament')";
                $stmt =$this->mysql->prepare($sql);
                $stmt->execute();
            }
            return 1;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //count number of organization
    public function countNumberOrganization() :array{
        $sql = 'SELECT count(*) as total FROM Ecurie';
        try{
            return $this->mysql->query($sql)->fetchAll();
        }catch(PDOException $e){
            throw new RuntimeException('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
    //verif if tournament exist
    public function verifIfTournamentExist(string $name): bool
    {
        $sql = "SELECT count(*) as total FROM Tournois WHERE NomTournoi = '$name'";
        try{
            $stmt = $this->mysql->query($sql);
            $result = $stmt->fetchAll();
            return end($result)['total'] >= 1;
        }catch(PDOException $e){
            throw new \RuntimeException('Error Processing Request select tournament participants ' .$e->getMessage(), 1);
        }
    }
    //select tournament by name
    public function selectTournamentByName(string $name):array{
        $sql = "SELECT IdTournoi FROM Tournois WHERE NomTournoi = '$name'";
        try{
            $stm = $this->mysql->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        }catch(PDOException $e){
            throw new Exception('Error Processing Request select tournament participents ' .$e->getMessage(), 1);
        }
    }
}
?>