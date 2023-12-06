<?php
require_once 'Connection.php';

class PrenotazioneDAO {

    public static function createPrenotazione($username, $dataPrenotazione, $n_persone, $is_inCorso, $n_tavolo) {
        try {
            DBAccess::open_connection();

            $sql = "INSERT INTO Prenotazione (Username, DataPrenotazione, NumPersone, InCorso, Tavolo) 
                VALUES (?, ?, ?, ?, ?)";

            // Prepara il statement
            $stmt = DBAccess::get_connection_state()->prepare($sql);

            // Lega i parametri
            $stmt->bind_param("ssiii", $username, $dataPrenotazione, $n_persone, $is_inCorso, $n_tavolo);

            // Esegui la query
            if($stmt->execute()) {
                echo "Prenotazione inserita con successo";
            } else {
                throw new Exception("Errore nell'inserimento della prenotazione: ".$stmt->error);
            }
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Chiudi il prepared statement e la connessione in ogni caso
            if(isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function getOldPrenotazioniByUsername($username, $todayPrenotation) {
        try {
            DBAccess::open_connection();

            $query = "SELECT  * from Prenotazione where Username = ? and DataPrenotazione != ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param('ss', $username, $todayPrenotation);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result set from the executed statement
            $result = $stmt->get_result();

            // Check for errors in executing the statement
            if(!$result) {
                throw new Exception('Error in query execution: '.DBAccess::get_connection_state()->error);
            }

            $rows = [];

            // Fetch the data from the result set
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Close the prepared statement and the database connection in every case
            if(isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }
    // Add more methods for CRUD operations on the User table

}
?>