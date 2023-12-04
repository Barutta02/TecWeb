<?php
require_once 'Connect.php';

class PrenotazioneDAO
{
    private static $conn;

    public function __construct()
    {
        self::$conn = Database::getInstance();
    }

    public static function createPrenotazione($username, $dataPrenotazione, $n_persone, $is_inCorso, $n_tavolo)
    {

        $sql = "INSERT INTO Prenotazione (Username, DataPrenotazione, NumPersone, InCorso, Tavolo) 
            VALUES (?, ?, ?, ?, ?)";

        // Prepara il statement
        $stmt = self::$conn->prepare($sql);

        // Lega i parametri
        $stmt->bind_param("ssiii", $username, $dataPrenotazione, $n_persone, $is_inCorso, $n_tavolo);

        // Esegui la query
        if ($stmt->execute()) {
            echo "Prenotazione inserita con successo";
        } else {
            echo "Errore nell'inserimento della prenotazione: " . $stmt->error;
        }
        // Chiudi il prepared statement e la connessione
        $stmt->close();
    }

    public static function getOldPrenotazioniByUsername($username, $todayPrenotation)
    {
        $query = "SELECT  * from Prenotazione where Username = ? and DataPrenotazione != ?";
        $stmt = self::$conn->prepare($query);
        $stmt->bind_param('ss', $username, $todayPrenotation);
        // Execute the prepared statement
        $stmt->execute();

        // Get the result set from the executed statement
        $result = $stmt->get_result();

        // Check for errors in executing the statement
        if (!$result) {
            die('Error in query execution: ' . self::$conn->error);
        }

        $rows = [];

        // Fetch the data from the result set
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        // Close the prepared statement
        $stmt->close();

        // Return the fetched data
        return $rows;
    }
    // Add more methods for CRUD operations on the User table

}


?>