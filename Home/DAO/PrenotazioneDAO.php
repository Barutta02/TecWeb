<?php
require_once 'Connection.php';

class PrenotazioneDAO
{
    /*
 CREATE TABLE prenotazione (
    utente                  VARCHAR(50),
    data_ora                TIMESTAMP,
    numero_persone          INT NOT NULL CHECK (numero_persone > 0),
    stato                   ENUM('DaSvolgersi', 'InCorso', 'Terminata') NOT NULL,
    tavolo                  INT NOT NULL,
    indicazione_aggiuntive  TEXT,
    PRIMARY KEY (utente,data_ora),
    FOREIGN KEY (utente) REFERENCES utente(username) ON DELETE CASCADE,
    FOREIGN KEY (tavolo) REFERENCES tavolo(id) ON DELETE CASCADE
);*/
    public static function createPrenotazione($username, $dataPrenotazione, $n_persone, $indicazioniAggiuntive, $is_inCorso, $n_tavolo)
    {
        try {
            DBAccess::open_connection();

            $sql = "INSERT INTO prenotazione (utente, data_ora, numero_persone, indicazioni_aggiuntive, stato, tavolo) 
                VALUES (?, ?, ?, ?, ?, ?)";

            // Prepara il statement
            $stmt = DBAccess::get_connection_state()->prepare($sql);

            // Lega i parametri
            $stmt->bind_param("ssissi", $username, $dataPrenotazione, $n_persone, $indicazioniAggiuntive, $is_inCorso, $n_tavolo);

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

            $query = "SELECT  * from prenotazione where utente = ? and data_ora != ?";
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

            $query = "SELECT  * from prenotazione where utente = ? and data_ora = ?";
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

            $query = "SELECT tavolo, data_ora, utente, numero_persone, indicazioni_aggiuntive  from prenotazione where stato = 'InCorso' order by data_ora         ";
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

            $sql = "UPDATE prenotazione SET stato = 'Terminata' WHERE utente = ? AND data_ora = ?";
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

    public static function EliminaPrenotazione($username, $timestamp_prenotazione)
    {
        try {
            DBAccess::open_connection();

            $query = "DELETE FROM prenotazione WHERE utente = ? AND data_ora = ?";
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

            $sql = "UPDATE prenotazione SET indicazioni_aggiuntive = ?, data_ora = ? WHERE utente = ? AND data_ora = ?";
            $stmt = DBAccess::get_connection_state()->prepare($sql);

            $stmt->bind_param("ssss", $indicazioniAggiuntive, $data, $username, $data);
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

            $query = "SELECT id, posti FROM tavolo WHERE posti>=? AND id NOT IN
            (SELECT id FROM tavolo JOIN prenotazione ON id=tavolo WHERE stato='InCorso') ORDER BY posti;";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("i", $n_persone);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows) {
                $tavolo = $result->fetch_assoc()["id"];
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