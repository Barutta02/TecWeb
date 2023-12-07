<?php
require_once 'Connection.php';
class TavoloDAO
{
    public static function getAvaibleTable()
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT T1.numPosti as numPosti, 
            COUNT(DISTINCT Prenotazione.Tavolo) as numeroOccupati, 
            COUNT(DISTINCT T1.IDTavolo) as totale_disp 
     FROM Tavolo as T1 
     LEFT JOIN Prenotazione ON T1.IDTavolo = Prenotazione.Tavolo AND Prenotazione.InCorso = 1
     GROUP BY T1.numPosti
     ORDER BY T1.numPosti;
     
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

}



?>