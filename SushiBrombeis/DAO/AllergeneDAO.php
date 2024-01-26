<?php
require_once 'Connection.php';

class AllergeneDAO
{
    public static function getAllAllergeni()
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT distinct nome  FROM allergene";
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

    public static function getAllergeniByPiatto($idPiatto)
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT nome FROM allergene where piatto = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            if (!$stmt) {
                throw new Throwable('Error in query preparation: ' . DBAccess::get_connection_state()->error);
            }
            $stmt->bind_param('i', $idPiatto);
            $stmt->execute();
            $result = $stmt->get_result();
            if (!$result) {
                throw new Throwable('Error in query execution: ' . DBAccess::get_connection_state()->error);
            }
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row["nome"];
            }
            $stmt->close();
            return $rows;
        } finally {
            DBAccess::close_connection();
        }
    }
}
?>