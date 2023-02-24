<?php
//create an admin class for dao
class AdminDAO extends DAO
{
    //constructor
    public function __construct()
    {
        parent::__construct();
    }
    // Insert an organization in the database (Ecurie table)
    public function insertOrganization(string $name, string $account, string $pwd, string $type)
    {
        try {
            $connection = parent::getConnection();
            $sql = "INSERT INTO Ecurie (Designation, TypeE, NomCompte, MDPCompte) VALUES (:nom, :type, :compte, :mdp)";
            $stmt = $connection->prepare($sql);
            $stmt->execute(array(
                ':nom' => $name,
                ':type' => $type,
                ':compte' => $account,
                ':mdp' => $pwd
            ));
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    // Create a tournament in the database (Tournois table)
    public function insertTournament(string $name, int $cashPrize, string $notoriety, string $city, string $startingHour, string $date, array $games): void
    {
        try {
            $connection = parent::getConnection();
            // Insert the tournament in the database (Tournois table)
            $sql = "INSERT INTO Tournois (NomTournoi, CashPrize, Notoriete, Lieu, DateHeureTournois) VALUES (:nom, :cashPrize, :notoriete, :lieu, :date)";
            $stmt = $connection->prepare($sql);
            $stmt->execute(array(
                ':nom' => $name,
                ':cashPrize' => $cashPrize,
                ':Notoriety' => $notoriety,
                ':lieu' => $city,
                ':date' => $date.' '.$startingHour.':00'
            ));
            // Get the id of the tournament
            $idTournament = $connection->lastInsertId();
            // Insert the games in the database (Contenir table)
            foreach ($games as $game) {
                $sql = "INSERT INTO Contenir (IdJeu, IdTournoi) VALUES (:jeu, :idTournoi)";
                $stmt = $connection->prepare($sql);
                $stmt->execute(array(
                    ':jeu' => $game,
                    ':idTournoi' => $idTournament
                ));
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}