<?php
require_once 'Connection.php';

class PrenotazioneDAO
{

    public static function createPrenotazione($username, $dataPrenotazione, $n_persone, $indicazioniAggiuntive, $is_inCorso, $n_tavolo)
    {
        try {
            DBAccess::open_connection();

            $sql = "INSERT INTO Prenotazione (Username, DataPrenotazione, NumPersone, IndicazioniAggiuntive, InCorso, Tavolo) 
                VALUES (?, ?, ?, ?, ?, ?)";

            // Prepara il statement
            $stmt = DBAccess::get_connection_state()->prepare($sql);

            // Lega i parametri
            $stmt->bind_param("ssisii", $username, $dataPrenotazione, $n_persone, $indicazioniAggiuntive, $is_inCorso, $n_tavolo);

            // Esegui la query
            if ($stmt->execute()) {
                echo "Prenotazione inserita con successo";
            } else {
                throw new Exception("Errore nell'inserimento della prenotazione: " . $stmt->error);
            }
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Chiudi il prepared statement e la connessione in ogni caso
            if (isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function getOldPrenotazioniByUsername($username, $todayPrenotation)
    {
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
            if (!$result) {
                throw new Exception('Error in query execution: ' . DBAccess::get_connection_state()->error);
            }

            $rows = [];

            // Fetch the data from the result set
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Close the prepared statement and the database connection in every case
            if (isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function getPrenotationByUsernameData($username, $data)
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT  * from Prenotazione where Username = ? and DataPrenotazione = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("ss", $username, $data);
            $stmt->execute();
            $result = $stmt->get_result();
            $prenotazione = $result->fetch_assoc();
            return $prenotazione;
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Close the prepared statement and the database connection in every case
            if (isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function getActivePrenotation()
    {

        try {
            DBAccess::open_connection();

            $query = "SELECT Tavolo, DataPrenotazione, Username, NumPersone  from Prenotazione where InCorso = 1 order by DataPrenotazione         ";
            $result = DBAccess::get_connection_state()->query($query);

            if ($result) {
                $rows = [];
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }

                return $rows;
            } else {
                die('Error in query: ' . mysqli_error(DBAccess::get_connection_state()));
            }
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Ensure the database connection is always closed
            DBAccess::close_connection();
        }
    }


    public static function TerminaPrenotazione($username, $dataPrenotazione)
    {
        try {
            DBAccess::open_connection();

            $sql = "UPDATE Prenotazione SET InCorso = 0 WHERE Username = ? AND DataPrenotazione = ?";
            $stmt = DBAccess::get_connection_state()->prepare($sql);

            $stmt->bind_param("ss", $username, $dataPrenotazione);
            $stmt->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        } finally {
            $stmt->close();
            DBAccess::close_connection();
        }
    }

    public static function EliminaPrenotazione($username, $timestamp_prenotazione) {
        try {
            DBAccess::open_connection();
            
            $query = "DELETE FROM Prenotazione WHERE Username = ? AND DataPrenotazione = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("ss", $username, $timestamp_prenotazione);
            $stmt->execute();
        } catch (Exception $errore) {
            die($errore->getMessage());
        } finally {
            $stmt->close();
            DBAccess::close_connection();
        }
    }


    public static function updatePrenotazione($username, $data, $indicazioniAggiuntive)
    {
        try {
            DBAccess::open_connection();

            $sql = "UPDATE Prenotazione SET IndicazioniAggiuntive = ?  WHERE Username = ? AND DataPrenotazione = ?";
            $stmt = DBAccess::get_connection_state()->prepare($sql);

            $stmt->bind_param("sss", $indicazioniAggiuntive, $username, $data);
            $stmt->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        } finally {
            $stmt->close();
            DBAccess::close_connection();
        }
    }
    
    
    public static function getTavoloForPrenotazione($n_persone)
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT IDTavolo, numPosti FROM Tavolo WHERE numPosti>=? AND IDTavolo NOT IN
            (SELECT IDTavolo FROM Tavolo JOIN Prenotazione ON IDTavolo=Tavolo WHERE InCorso=1) ORDER BY numPosti;";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("i", $n_persone);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows){
                $tavolo = $result->fetch_assoc()["IDTavolo"];
                return $tavolo;
            }
            return null;
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Close the prepared statement and the database connection in every case
            if (isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

}
?>