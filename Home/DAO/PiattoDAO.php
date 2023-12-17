<?php
require_once 'Connection.php';

class PiattoDAO
{

    public static function getPiattoById($id)
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT * FROM Piatto WHERE IDPiatto = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();

            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Ensure the database connection is always closed
            DBAccess::close_connection();
        }
    }

    private static function isTimeForDinner()
    {
        $currentHour = date('H');
        return ($currentHour >= 18 && $currentHour < 23);
    }

    public static function getPlatesByHours_Category($categoria)
    {
        try {
            if (self::isTimeForDinner()) {
                return self::getPiattoByTipoCategory_TipoMenu($categoria, "Cena");
            } else {
                return self::getPiattoByTipoCategory_TipoMenu($categoria, "Pranzo");
            }
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        }
    }

    public static function getPiattoByTipoMenu($tipo)
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT * FROM Piatto WHERE TipoMenu = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);

            // Check for errors in preparing the statement
            if (!$stmt) {
                throw new Exception('Error in query preparation: ' . DBAccess::get_connection_state()->error);
            }

            // Bind the parameter
            $stmt->bind_param('s', $tipo);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result set from the executed statement
            $result = $stmt->get_result();

            // Check for errors in executing the statement
            if (!$result) {
                throw new Exception('Error in query execution: ' . DBAccess::get_connection_state()->error);
            }

            $rows = [];

            // Fetch the data from the result set
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Ensure the database connection is always closed
            DBAccess::close_connection();
        }
    }

    public static function getPiattoByTipoCategory_TipoMenu($categoria, $tipoMenu)
    {
        try {
            DBAccess::open_connection();
            if ($tipoMenu == "Cena") {
                $query = "SELECT * FROM Piatto WHERE Categoria = ?";

            } else {
                $query = "SELECT * FROM Piatto WHERE Categoria = ? and TipoMenu = 'Pranzo'";
            }
            $stmt = DBAccess::get_connection_state()->prepare($query);
            // Check for errors in preparing the statement
            if (!$stmt) {
                throw new Exception('Error in query preparation: ' . DBAccess::get_connection_state()->error);
            }

            // Bind the parameter
            $stmt->bind_param('s', $categoria);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result set from the executed statement
            $result = $stmt->get_result();

            // Check for errors in executing the statement
            if (!$result) {
                throw new Exception('Error in query execution: ' . DBAccess::get_connection_state()->error);
            }

            $rows = [];

            // Fetch the data from the result set
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Ensure the database connection is always closed
            DBAccess::close_connection();
        }
    }

    public static function getAllPiatti()
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT * FROM Piatto";
            $result = DBAccess::get_connection_state()->query($query);

            if ($result) {
                $rows = [];
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }

                return $rows;
            } else {
                throw new Exception('Error in query: ' . mysqli_error(DBAccess::get_connection_state()));
            }
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Ensure the database connection is always closed
            DBAccess::close_connection();
        }
    }

    public static function addPiatto($nome, $descrizione, $prezzo, $tipoMenu, $tipoPortata)
    {
        try {
            DBAccess::open_connection();

            $query = "INSERT INTO Piatto (NomePiatto, Descrizione, Prezzo, TipoMenu, TipoPortata) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param('ssdss', $nome, $descrizione, $prezzo, $tipoMenu, $tipoPortata);

            return $stmt->execute();
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Ensure the database connection is always closed
            DBAccess::close_connection();
        }
    }

    // Function to update a dish in the table
    public static function updateDish($id, $nome, $descrizione, $prezzo, $tipoMenu, $tipoPortata)
    {
        try {
            DBAccess::open_connection();

            $query = "UPDATE Piatto SET NomePiatto = ?, Descrizione = ?, Prezzo = ?, TipoMenu = ?, TipoPortata = ? WHERE IDPiatto = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bindParam(1, $nome);
            $stmt->bindParam(2, $descrizione);
            $stmt->bindParam(3, $prezzo);
            $stmt->bindParam(4, $tipoMenu);
            $stmt->bindParam(5, $tipoPortata);
            $stmt->bindParam(6, $id);

            return $stmt->execute();
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Ensure the database connection is always closed
            DBAccess::close_connection();
        }
    }

    // Function to delete a dish from the table
    public static function deleteDish($id)
    {
        try {
            DBAccess::open_connection();
            $query = "DELETE FROM Piatto WHERE IDPiatto = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bindParam(1, $id);

            return $stmt->execute();
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