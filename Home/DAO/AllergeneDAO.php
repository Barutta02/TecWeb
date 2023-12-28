<?php
require_once 'Connection.php';

class AllergeneDAO
{
    /* CREATE TABLE allergene (
        nome                VARCHAR(50),
        piatto              INT,
        PRIMARY KEY (nome,piatto),
        FOREIGN KEY (piatto) REFERENCES piatto(id) ON DELETE CASCADE
    );
     */
    public static function getAllAllergeni()
    {
        try {
            // Open the database connection
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
            // Ensure the database connection is always closed
            DBAccess::close_connection();
        }
    }

    public static function getAllergeniByPiatto($idPiatto)
    {
        try {
            // Open the database connection
            DBAccess::open_connection();

            $query = "SELECT nome FROM allergene where piatto = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);

            // Check for errors in preparing the statement
            if (!$stmt) {
                throw new Throwable('Error in query preparation: ' . DBAccess::get_connection_state()->error);
            }

            // Bind the parameter
            $stmt->bind_param('i', $idPiatto);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result set from the executed statement
            $result = $stmt->get_result();

            // Check for errors in executing the statement
            if (!$result) {
                throw new Throwable('Error in query execution: ' . DBAccess::get_connection_state()->error);
            }

            $rows = [];

            // Fetch the data from the result set
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row["nome"];
            }

            // Close the prepared statement
            $stmt->close();

            return $rows;
        } finally {
            // Close the database connection
            DBAccess::close_connection();
        }
    }
}
?>