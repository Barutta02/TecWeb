<?php
require_once 'Connect.php';
class PiattoDAO
{
    private static $conn;

    public function __construct()
    {
        $db = Database::getInstance();
        self::$conn = $db->getConnection();
    }

    public static function getPiattoById($id)
    {
        $query = "SELECT * FROM Piatto WHERE IDPiatto = ?";
        $stmt = self::$conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    private static function isTimeForDinner()
    {
        $currentHour = date('H');
        return ($currentHour >= 18 && $currentHour < 22);
    }

    public static function getPlatesByHours()
    {
        if (self::isTimeForDinner()) {
            return self::getAllPiatti();
        } else {
            return self::getPiattoByTipoMenu('Pranzo');
        }
    }

    public static function getPiattoByTipoMenu($tipo)
    {
        $query = "SELECT * FROM Piatto WHERE TipoMenu = ?";
        $stmt = self::$conn->prepare($query);
        // Check for errors in preparing the statement
        if (!$stmt) {
            die('Error in query preparation: ' . self::$conn->error);
        }
        // Bind the parameter
        $stmt->bind_param('s', $tipo);
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
            $rows[] = $row;
        }

        // Close the prepared statement
        $stmt->close();

        // Return the fetched data
        return $rows;
    }


    public static function getPiattoByTipoCategory($categoria)
    {
        $query = "SELECT * FROM Piatto WHERE Categoria = ?";
        $stmt = self::$conn->prepare($query);
        // Check for errors in preparing the statement
        if (!$stmt) {
            die('Error in query preparation: ' . self::$conn->error);
        }
        // Bind the parameter
        $stmt->bind_param('s', $categoria);
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
            $rows[] = $row;
        }

        // Close the prepared statement
        $stmt->close();

        // Return the fetched data
        return $rows;
    }



    public static function getAllPiatti()
    {
        $query = "SELECT * FROM Piatto";
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

    public static function addPiatto($nome, $descrizione, $prezzo, $tipoMenu, $tipoPortata)
    {
        $query = "INSERT INTO Piatto (NomePiatto, Descrizione, Prezzo, TipoMenu, TipoPortata) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = self::$conn->prepare($query);
        $stmt->bind_param('ssdss', $nome, $descrizione, $prezzo, $tipoMenu, $tipoPortata);

        return $stmt->execute();
    }
    // Function to insert a new dish into the table


    // Function to update a dish in the table
    public static function updateDish($id, $nome, $descrizione, $prezzo, $tipoMenu, $tipoPortata)
    {
        $query = "UPDATE Piatto SET NomePiatto = ?, Descrizione = ?, Prezzo = ?, TipoMenu = ?, TipoPortata = ? WHERE IDPiatto = ?";
        $stmt = self::$conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $descrizione);
        $stmt->bindParam(3, $prezzo);
        $stmt->bindParam(4, $tipoMenu);
        $stmt->bindParam(5, $tipoPortata);
        $stmt->bindParam(6, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Function to delete a dish from the table
    public static function deleteDish($id)
    {
        $query = "DELETE FROM Piatto WHERE IDPiatto = ?";
        $stmt = self::$conn->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>