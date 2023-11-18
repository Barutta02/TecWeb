<?php
require_once 'Connect.php';
class AllergeneDAO
{
    private static $conn;

    public function __construct()
    {
        $db = Database::getInstance();
        self::$conn = $db->getConnection();
    }


    public static function getAllAllergeni()
    {
        $query = "SELECT * FROM Allergene";
        $result = self::$conn->query($query);

        if ($result) {
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            die('Error in query: ' . mysqli_error(self::$conn));
        }
    }

    public static function getAllergeniByPiatto($idPiatto)
    {
        $query = "SELECT Allergene FROM AllergenePiatto where Piatto = ? ";
        $stmt = self::$conn->prepare($query);
        // Check for errors in preparing the statement
        if (!$stmt) {
            die('Error in query preparation: ' . self::$conn->error);
        }
        // Bind the parameter
        $stmt->bind_param('i', $idPiatto);
        // Execute the prepared statement
        $stmt->execute();

        // Get the result set from the executed statement
        $result = $stmt->get_result();

        // Check for errors in executing the statement
        if (!$result) {
            die('Error in query execution: ' . self::$conn->error);
        }

        $rows = [];
        // Fetch the data from the result set
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row["Allergene"];
        }

        // Close the prepared statement
        $stmt->close();

        // Return the fetched data
        return $rows;
    }



}
?>