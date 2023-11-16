<?php
require_once 'Connect.php';

class UserDao
{
    private $conn;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }

    public function getUserByUsername($username)
    {
        $query = "SELECT * FROM User WHERE Username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        return $user;
    }
    public function getUserByUsernamePassword($username, $password)
    {
        $query = "SELECT * FROM User WHERE Username = ? AND Password = ?";
        $stmt = $this->conn->prepare($query);

        // Check if the statement was successfully prepared
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("ss", $username, $password);

            // Execute the statement
            $stmt->execute();

            // Get the result set
            $result = $stmt->get_result();

            // Fetch the user data
            $user = $result->fetch_assoc();

            // Close the statement
            $stmt->close();

            // Return the user data
            return $user;
        } else {
            // Handle the error if the statement was not prepared successfully
            echo "Error preparing statement: " . $this->conn->error;
            return null; // Or handle the error in an appropriate way
        }
    }


    public function getUserByEmailPassword($email, $password)
    {
        $query = "SELECT * FROM User WHERE Email = ? AND Password = ?";
        $stmt = $this->conn->prepare($query);

        // Check if the statement was successfully prepared
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("ss", $email, $password);

            // Execute the statement
            $stmt->execute();

            // Get the result set
            $result = $stmt->get_result();

            // Fetch the user data
            $user = $result->fetch_assoc();

            // Close the statement
            $stmt->close();

            // Return the user data
            return $user;
        } else {
            // Handle the error if the statement was not prepared successfully
            echo "Error preparing statement: " . $this->conn->error;
            return null; // Or handle the error in an appropriate way
        }
    }

    public function createUser($username, $name, $surname, $email, $password)
    {
        $query = "INSERT INTO User (Username, Nome, Cognome, Email, Password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $username, $name, $surname, $email, $password);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function updateUser($username, $name, $surname, $email, $password)
    {
        $query = "UPDATE User SET Nome=?, Cognome=?, Email=?, Password=? WHERE Username=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $name, $surname, $email, $password, $username);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function deleteUser($username)
    {
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