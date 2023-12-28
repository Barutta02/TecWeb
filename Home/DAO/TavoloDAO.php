<?php
require_once 'Connection.php';
class TavoloDAO
{
    /*
    CREATE TABLE tavolo (
    id      INT PRIMARY KEY,
    posti   INT NOT NULL CHECK (posti > 0)
);
    */
    public static function getAvaibleTable()
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT T1.posti as numPosti, 
            COUNT(DISTINCT Prenotazione.tavolo) as numeroOccupati, 
            COUNT(DISTINCT T1.id) as totale_disp 
     FROM Tavolo as T1 
     LEFT JOIN Prenotazione ON T1.id = Prenotazione.tavolo AND Prenotazione.stato = 'InCorso'
     GROUP BY T1.posti
     ORDER BY T1.posti;
     
     ";
            $result = mysqli_query(DBAccess::get_connection_state(), $query);

            if ($result) {
                $rows = [];
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
                $result->free();
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

    public static function getMaxPosti()
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT MAX(posti) AS maxPosti FROM Tavolo;";
            $result = mysqli_query(DBAccess::get_connection_state(), $query);

            if ($result) {
                $row = $result->fetch_assoc();
                $result->free();
                return $row["maxPosti"];
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

}



?>