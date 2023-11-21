<?php
require_once 'Connect.php';

class OrdineDAO
{
    private static $conn;

    public function __construct()
    {
        $db = Database::getInstance();
        self::$conn = $db->getConnection();
    }

    public static function createOrdine($idPiatto, $username, $dataOraOrdine, $dataPrenotazione, $quantita, $consegnato = false)
    {
        $sql = "INSERT INTO Ordine (IDPiatto, Username, DataOraOrdine, DataPrenotazione, Quantita, Consegnato) 
            VALUES (?, ?, ?, ?, ?, ?)";

        // Prepara il statement
        $stmt = self::$conn->prepare($sql);

        // Lega i parametri
        $stmt->bind_param("isssii", $idPiatto, $username, $dataOraOrdine, $dataPrenotazione, $quantita, $consegnato);
        // Esegui la query
        if ($stmt->execute()) {
            echo "Ordine inserito con successo";
        } else {
            echo "Errore nell'inserimento dell'ordine: " . $stmt->error;
        }
        // Chiudi il prepared statement e la connessione
        $stmt->close();
    }


    // Add more methods for CRUD operations on the User table
}


// Repeat the process for other DAO classes (AllergeneDao, TavoloDao, PrenotazioneDao, OrdineDao, RecensioniDao)
?>