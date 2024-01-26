<?php
require_once 'Connection.php';
class TavoloDAO
{
    public static function getAvaibleTable()
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT T1.posti as numPosti, 
            COUNT(DISTINCT prenotazione.tavolo) as numeroOccupati, 
            COUNT(DISTINCT T1.id) as totale_disp 
     FROM tavolo as T1 
     LEFT JOIN prenotazione ON T1.id = prenotazione.tavolo AND prenotazione.stato = 'InCorso'
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
                throw new Throwable('Error in query: ' . mysqli_error(DBAccess::get_connection_state()));
            }
        } finally {
            DBAccess::close_connection();
        }
    }

    public static function getMaxPosti()
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT MAX(posti) AS maxPosti FROM tavolo;";
            $result = mysqli_query(DBAccess::get_connection_state(), $query);
            if ($result) {
                $row = $result->fetch_assoc();
                $result->free();
                return $row["maxPosti"];
            } else {
                throw new Throwable('Error in query: ' . mysqli_error(DBAccess::get_connection_state()));
            }
        } finally {
            DBAccess::close_connection();
        }
    }

}



?>