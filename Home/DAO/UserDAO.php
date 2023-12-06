<?php
require_once 'Connection.php';

class UserDao {

    public static function getUserByUsername($username) {
        try {
            DBAccess::open_connection();

            $query = "SELECT * FROM User WHERE Username = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            return $user;
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Close the prepared statement and the database connection in every case
            if(isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function getUserByUsernamePassword($username, $password) {
        try {
            DBAccess::open_connection();

            $query = "SELECT * FROM User WHERE Username = ? AND Password = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);

            // Check if the statement was successfully prepared
            if($stmt) {
                // Bind parameters
                $stmt->bind_param("ss", $username, $password);

                // Execute the statement
                $stmt->execute();

                // Get the result set
                $result = $stmt->get_result();

                // Fetch the user data
                $user = $result->fetch_assoc();

                return $user;
            } else {
                // Handle the error if the statement was not prepared successfully
                throw new Exception("Error preparing statement: ".DBAccess::get_connection_state()->error);
            }
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Close the prepared statement and the database connection in every case
            if(isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function getUserByEmailPassword($email, $password) {
        try {
            DBAccess::open_connection();

            $query = "SELECT * FROM User WHERE Email = ? AND Password = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);

            // Check if the statement was successfully prepared
            if($stmt) {
                // Bind parameters
                $stmt->bind_param("ss", $email, $password);

                // Execute the statement
                $stmt->execute();

                // Get the result set
                $result = $stmt->get_result();

                // Fetch the user data
                $user = $result->fetch_assoc();

                return $user;
            } else {
                // Handle the error if the statement was not prepared successfully
                throw new Exception("Error preparing statement: ".DBAccess::get_connection_state()->error);
            }
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Close the prepared statement and the database connection in every case
            if(isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function createUser($username, $name, $surname, $email, $password) {
        try {
            DBAccess::open_connection();

            $query = "INSERT INTO User (Username, Nome, Cognome, Email, Password) VALUES (?, ?, ?, ?, ?)";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("sssss", $username, $name, $surname, $email, $password);
            $success = $stmt->execute();

            return $success;
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Close the prepared statement and the database connection in every case
            if(isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function updateUser($username, $name, $surname, $email, $password) {
        try {
            DBAccess::open_connection();

            $query = "UPDATE User SET Nome=?, Cognome=?, Email=?, Password=? WHERE Username=?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("sssss", $name, $surname, $email, $password, $username);
            $success = $stmt->execute();

            return $success;
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Close the prepared statement and the database connection in every case
            if(isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function deleteUser($username) {
        try {
            DBAccess::open_connection();

            $query = "DELETE FROM User WHERE Username=?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();

            return $success;
        } catch (Exception $e) {
            // Handle the exception (log, display an error message, etc.)
            die($e->getMessage());
        } finally {
            // Close the prepared statement and the database connection in every case
            if(isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    // Add more methods for CRUD operations on the User table
}
?>