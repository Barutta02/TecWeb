<?php
require_once 'Connect.php';
class CategoriaDAO
{
    private $conn;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }

    
    public function getAllCategory()
    {
        $query = "SELECT * FROM Categoria";
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

  
}
?>