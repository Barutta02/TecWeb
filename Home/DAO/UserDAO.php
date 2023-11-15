<?php
require_once 'Connect.php';

class UserDao {
    private $conn;

    public function __construct() {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }

    public function getUserByUsername($username) {
        $query = "SELECT * FROM User WHERE Username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        return $user;
    }

    public function createUser($username, $name, $surname, $email, $password) {
        $query = "INSERT INTO User (Username, Nome, Cognome, Email, Password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $username, $name, $surname, $email, $password);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function updateUser($username, $name, $surname, $email, $password) {
        $query = "UPDATE User SET Nome=?, Cognome=?, Email=?, Password=? WHERE Username=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $name, $surname, $email, $password, $username);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function deleteUser($username) {
        $query = "DELETE FROM User WHERE Username=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    // Add more methods for CRUD operations on the User table
}


// Repeat the process for other DAO classes (AllergeneDao, TavoloDao, PrenotazioneDao, OrdineDao, RecensioniDao)
?>
