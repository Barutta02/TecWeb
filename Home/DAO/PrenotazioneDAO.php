<?php
require_once 'Connect.php';

class PrenotazioneDAO
{
    private static $conn;

    public function __construct()
    {
        $db = Database::getInstance();
        self::$conn = $db->getConnection();
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


}


?>