<?php
require_once 'Connection.php';
class CategoriaDAO
{
    public static function getAllCategory()
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT distinct categoria FROM piatto";
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

}



?>