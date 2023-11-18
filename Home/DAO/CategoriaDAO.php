<?php
require_once 'Connect.php';
class CategoriaDAO
{
    private static $conn;

    public function __construct()
    {
        $db = Database::getInstance();
        self::$conn = $db->getConnection();
    }


    public static function getAllCategory()
    {
        $query = "SELECT * FROM Categoria";
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


}
?>