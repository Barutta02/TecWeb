<?php
require_once 'Connect.php';
class PiattoDAO
{
    private $conn;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }

    public function getPiattoById($id)
    {
        $query = "SELECT * FROM Piatto WHERE IDPiatto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getAllPiatti()
    {
        $query = "SELECT * FROM Piatto";
        $result = $this->conn->query($query);

        if ($result) {
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            die('Error in query: ' . mysqli_error($this->conn));
        }
    }

    public function addPiatto($nome, $descrizione, $prezzo, $tipoMenu, $tipoPortata)
    {
        $query = "INSERT INTO Piatto (NomePiatto, Descrizione, Prezzo, TipoMenu, TipoPortata) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssdss', $nome, $descrizione, $prezzo, $tipoMenu, $tipoPortata);

        return $stmt->execute();
    }
    // Function to insert a new dish into the table


    // Function to update a dish in the table
    public function updateDish($id, $nome, $descrizione, $prezzo, $tipoMenu, $tipoPortata)
    {
        $query = "UPDATE Piatto SET NomePiatto = ?, Descrizione = ?, Prezzo = ?, TipoMenu = ?, TipoPortata = ? WHERE IDPiatto = ?";
        $stmt = $this->conn->prepare($query);
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
    public function deleteDish($id)
    {
        $query = "DELETE FROM Piatto WHERE IDPiatto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>