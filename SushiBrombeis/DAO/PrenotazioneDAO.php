<?php
require_once 'Connection.php';

class PrenotazioneDAO
{
    public static function createPrenotazione($username, $dataPrenotazione, $n_persone, $indicazioniAggiuntive, $is_inCorso, $n_tavolo)
    {
        try {
            DBAccess::open_connection();
            $sql = "INSERT INTO prenotazione (utente, data_ora, numero_persone, indicazioni_aggiuntive, stato, tavolo) 
                VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = DBAccess::get_connection_state()->prepare($sql);
            $stmt->bind_param("ssissi", $username, $dataPrenotazione, $n_persone, $indicazioniAggiuntive, $is_inCorso, $n_tavolo);
            if (!$stmt->execute()) {
                throw new Throwable("Errore nell'inserimento della prenotazione: " . $stmt->error);
            }
        } finally {
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
        } finally {
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
                throw new Throwable('Error in query: ' . mysqli_error(DBAccess::get_connection_state()));
            }
        } finally {
            DBAccess::close_connection();
        }
    }
    public static function getActivePrenotationByUsername($username)
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT * from prenotazione where utente = ? and stato = 'InCorso' order by data_ora desc limit 1";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $prenotazione = $result->fetch_assoc();
            return $prenotazione;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function TerminaPrenotazione($username, $dataPrenotazione)
    {
        try {
            DBAccess::open_connection();
            $sql = "UPDATE prenotazione SET stato = 'Terminata', data_ora = ? WHERE utente = ? AND data_ora = ?";
            $stmt = DBAccess::get_connection_state()->prepare($sql);
            $stmt->bind_param("sss", $dataPrenotazione, $username, $dataPrenotazione);
            $stmt->execute();
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
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

}
?>