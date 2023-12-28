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