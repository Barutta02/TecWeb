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
            $sql = "INSERT INTO ordine (piatto, utente, data_ora, data_prenotazione, quantita, consegnato) 
                VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = DBAccess::get_connection_state()->prepare($sql);
            $stmt->bind_param("isssii", $idPiatto, $username, $dataOraOrdine, $dataPrenotazione, $quantita, $consegnato);
            if (!$stmt->execute()) {
                throw new Throwable('Error in query execution: ' . DBAccess::get_connection_state()->error);
            }
        } finally {
            DBAccess::close_connection();
        }
    }

    public static function getOrdineByPrenotazione($username, $data)
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT  piatto.nome as nome,piatto.descrizione as descrizione, ordine.quantita as quantita, ordine.consegnato as consegnato  
                      FROM ordine JOIN piatto on piatto.id = ordine.piatto 
                      WHERE ordine.utente = ? and ordine.data_prenotazione = ? 
                      Order by ordine.consegnato";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param('ss', $username, $data);
            $stmt->execute();
            $result = $stmt->get_result();
            if (!$result) {
                throw new Throwable('Error in query execution: ' . DBAccess::get_connection_state()->error);
            }
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } finally {
            DBAccess::close_connection();
        }
    }

    public static function getOrdiniFrequenti($username)
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT DISTINCT piatto.nome as nome, piatto.descrizione as descrizione, count(*) as frequenza
                      FROM ordine JOIN piatto on piatto.id = ordine.piatto WHERE ordine.utente = ?
                      GROUP BY nome ORDER BY frequenza DESC LIMIT 8;";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if (!$result) {
                throw new Throwable('Error in query execution: ' . DBAccess::get_connection_state()->error);
            }
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } finally {
            DBAccess::close_connection();
        }
    }

    public static function getAllToDoOrder()
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT  piatto.nome as nome,piatto.Descrizione as descrizione, ordine.quantita as quantita, 
                              ordine.consegnato as consegnato, ordine.data_ora as data_ora , ordine.piatto as id, 
                              ordine.utente as cliente, prenotazione.tavolo as tavolo
                      FROM ordine JOIN piatto on piatto.id = ordine.piatto 
                      JOIN prenotazione on prenotazione.utente = ordine.utente and prenotazione.data_ora = ordine.data_prenotazione
                      WHERE ordine.consegnato = 0";
            $result = DBAccess::get_connection_state()->query($query);
            if ($result) {
                $rows = [];
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
                return $rows;
            } else {
                throw new Throwable('Error in query: ' . mysqli_error(DBAccess::get_connection_state()));
            }
        } finally {
            DBAccess::close_connection();
        }
    }

    public static function aggiornaStatoConsegna($idPiatto, $username, $dataOraOrdine, $nuovoStatoConsegnato)
    {
        try {
            DBAccess::open_connection();
            $sql = "UPDATE ordine SET consegnato = ? WHERE piatto = ? AND utente = ? AND data_ora = ?";
            $stmt = DBAccess::get_connection_state()->prepare($sql);
            $stmt->bind_param("siss", $nuovoStatoConsegnato, $idPiatto, $username, $dataOraOrdine);
            $stmt->execute();
        } finally {
            $stmt->close();
            DBAccess::close_connection();
        }
    }
}
?>