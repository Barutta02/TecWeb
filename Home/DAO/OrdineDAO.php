<?php
require_once 'Connection.php';

class OrdineDAO
{

    public static function createOrdine($idPiatto, $username, $dataOraOrdine, $dataPrenotazione, $quantita, $consegnato = false)
    {
        try {
            DBAccess::open_connection();

            $sql = "INSERT INTO Ordine (IDPiatto, Username, DataOraOrdine, DataPrenotazione, Quantita, Consegnato) 
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

            $query = "SELECT  Piatto.NomePiatto as NomePiatto,Piatto.Descrizione as Descrizione, Ordine.Quantita as Quantita, Ordine.Consegnato as isConsegnato  
                      FROM Ordine JOIN Piatto on Piatto.IDPiatto = Ordine.IDPiatto 
                      WHERE Ordine.Username = ? and Ordine.DataPrenotazione = ? 
                      Order by Ordine.Consegnato";

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

    public static function getAllToDoOrder()
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT  Piatto.NomePiatto as NomePiatto,Piatto.Descrizione as Descrizione, Ordine.Quantita as Quantita, 
                              Ordine.Consegnato as isConsegnato, Ordine.DataOraOrdine as Dataora , Ordine.IDPiatto as IDPiatto, 
                              Ordine.Username as cliente, Prenotazione.Tavolo as Tavolo
                      FROM Ordine JOIN Piatto on Piatto.IDPiatto = Ordine.IDPiatto 
                      JOIN Prenotazione on Prenotazione.Username = Ordine.Username and Prenotazione.DataPrenotazione = Ordine.DataPrenotazione
                      WHERE Ordine.Consegnato = 0";

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

            $sql = "UPDATE Ordine SET Consegnato = ? WHERE IDPiatto = ? AND Username = ? AND DataOraOrdine = ?";
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