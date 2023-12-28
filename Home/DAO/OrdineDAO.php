<?php
require_once 'Connection.php';

class OrdineDAO
{

    /*
    CREATE TABLE ordine (
    utente              VARCHAR(50),
    piatto              INT,
    data_ora            TIMESTAMP,
    data_prenotazione   TIMESTAMP NOT NULL,
    quantita            INT NOT NULL CHECK (quantita > 0),
    consegnato          BOOLEAN NOT NULL,
    PRIMARY KEY (utente,piatto,data_ora),
    FOREIGN KEY (utente,data_prenotazione) REFERENCES prenotazione(utente,data_ora) ON DELETE CASCADE,
    FOREIGN KEY (piatto) REFERENCES piatto(id) ON DELETE CASCADE
); */

    public static function createOrdine($idPiatto, $username, $dataOraOrdine, $dataPrenotazione, $quantita, $consegnato = false)
    {
        try {
            DBAccess::open_connection();

            $sql = "INSERT INTO Ordine (piatto, utente, data_ora, data_prenotazione, quantita, consegnato) 
                VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = DBAccess::get_connection_state()->prepare($sql);
            $stmt->bind_param("isssii", $idPiatto, $username, $dataOraOrdine, $dataPrenotazione, $quantita, $consegnato);

            if ($stmt->execute()) {
                echo "Ordine inserito con successo";
            } else {
                echo "Errore nell'inserimento dell'ordine: " . $stmt->error;
            }
        } catch (Exception $e) {
            die($e->getMessage());
        } finally {
            DBAccess::close_connection();
        }
    }

    public static function getOrdineByPrenotazione($username, $data)
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT  Piatto.nome as nome,Piatto.descrizione as descrizione, Ordine.quantita as quantita, Ordine.consegnato as consegnato  
                      FROM Ordine JOIN Piatto on Piatto.id = Ordine.piatto 
                      WHERE Ordine.utente = ? and Ordine.data_prenotazione = ? 
                      Order by Ordine.consegnato";

            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param('ss', $username, $data);

            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                die('Error in query execution: ' . DBAccess::get_connection_state()->error);
            }

            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        } catch (Exception $e) {
            die($e->getMessage());
        } finally {
            DBAccess::close_connection();
        }
    }

    public static function getOrdiniFrequenti($username)
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT DISTINCT Piatto.nome as nome, Piatto.descrizione as descrizione, count(*) as Frequenza
                      FROM Ordine JOIN Piatto on Piatto.id = Ordine.piatto WHERE Ordine.utente = ?
                      GROUP BY nome ORDER BY Frequenza DESC LIMIT 8;";

            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param('s', $username);

            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                die('Error in query execution: ' . DBAccess::get_connection_state()->error);
            }

            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        } catch (Exception $e) {
            die($e->getMessage());
        } finally {
            DBAccess::close_connection();
        }
    }

    public static function getAllToDoOrder()
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT  Piatto.nome as nome,Piatto.Descrizione as descrizione, Ordine.quantita as quantita, 
                              Ordine.consegnato as consegnato, Ordine.data_ora as data_ora , Ordine.piatto as id, 
                              Ordine.utente as cliente, Prenotazione.tavolo as tavolo
                      FROM Ordine JOIN Piatto on Piatto.id = Ordine.piatto 
                      JOIN Prenotazione on Prenotazione.utente = Ordine.utente and Prenotazione.data_ora = Ordine.data_prenotazione
                      WHERE Ordine.consegnato = 0";

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
            die($e->getMessage());
        } finally {
            DBAccess::close_connection();
        }
    }

    public static function aggiornaStatoConsegna($idPiatto, $username, $dataOraOrdine, $nuovoStatoConsegnato)
    {
        try {
            DBAccess::open_connection();

            $sql = "UPDATE Ordine SET consegnato = ? WHERE piatto = ? AND utente = ? AND data_ora = ?";
            $stmt = DBAccess::get_connection_state()->prepare($sql);

            $stmt->bind_param("siss", $nuovoStatoConsegnato, $idPiatto, $username, $dataOraOrdine);
            $stmt->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        } finally {
            $stmt->close();
            DBAccess::close_connection();
        }
    }
}
?>