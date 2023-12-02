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

    public static function getOrdineByPrenotazione($username, $data)
    {
        $query = "SELECT  Piatto.NomePiatto as NomePiatto,Piatto.Descrizione as Descrizione, Ordine.Quantita as Quantita, Ordine.Consegnato as isConsegnato  FROM Ordine JOIN Piatto on Piatto.IDPiatto = Ordine.IDPiatto WHERE Ordine.Username = ? and Ordine.DataPrenotazione = ? Order by Ordine.Consegnato";
        $stmt = self::$conn->prepare($query);
        $stmt->bind_param('ss', $username, $data);
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

    public static function getAllToDoOrder()
    {
        $query = "SELECT  Piatto.NomePiatto as NomePiatto,Piatto.Descrizione as Descrizione, Ordine.Quantita as Quantita, Ordine.Consegnato as isConsegnato, Ordine.DataOraOrdine as Dataora , Ordine.IDPiatto as IDPiatto, Ordine.Username as cliente  FROM Ordine JOIN Piatto on Piatto.IDPiatto = Ordine.IDPiatto WHERE Ordine.Consegnato = 0";
        $stmt = self::$conn->prepare($query);
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

function aggiornaStatoConsegna($idPiatto, $username, $dataOraOrdine, $nuovoStatoConsegnato) {
    // Preparazione della query di aggiornamento
    $sql = "UPDATE Ordine SET Consegnato = ? WHERE IDPiatto = ? AND Username = ? AND DataOraOrdine = ?";

    // Preparazione dello statement
    $stmt = self::$conn->prepare($sql);

    // Binding dei parametri
    $stmt->bind_param("siss", $nuovoStatoConsegnato, $idPiatto, $username, $dataOraOrdine);

    // Esecuzione dello statement
    $stmt->execute();

    // Chiusura dello statement e della connessione
    $stmt->close();
}
}


// Repeat the process for other DAO classes (AllergeneDao, TavoloDao, PrenotazioneDao, OrdineDao, RecensioniDao)
?>