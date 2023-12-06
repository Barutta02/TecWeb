<?php
require_once 'Connection.php';

class AllergeneDAO {

    public static function getAllAllergeni() {
        try {
            // Open the database connection
            DBAccess::open_connection();

            $query = "SELECT * FROM Allergene";
            $result = DBAccess::get_connection_state()->query($query);

            if($result) {
                $rows = [];
                while($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }

                return $rows;
            } else {
                throw new Exception('Error in query: '.mysqli_error(DBAccess::get_connection_state()));
            }
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Ensure the database connection is always closed
            DBAccess::close_connection();
        }
    }

    public static function getAllergeniByPiatto($idPiatto) {
        try {
            // Open the database connection
            DBAccess::open_connection();

            $query = "SELECT Allergene FROM AllergenePiatto where Piatto = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);

            // Check for errors in preparing the statement
            if(!$stmt) {
                die('Error in query preparation: '.DBAccess::get_connection_state()->error);
            }

            // Bind the parameter
            $stmt->bind_param('i', $idPiatto);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result set from the executed statement
            $result = $stmt->get_result();

            // Check for errors in executing the statement
            if(!$result) {
                die('Error in query execution: '.DBAccess::get_connection_state()->error);
            }

            $rows = [];

            // Fetch the data from the result set
            while($row = $result->fetch_assoc()) {
                $rows[] = $row["Allergene"];
            }

            // Close the prepared statement
            $stmt->close();

            return $rows;
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Close the database connection
            DBAccess::close_connection();
        }
    }
}
?>