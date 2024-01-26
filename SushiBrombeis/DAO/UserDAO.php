<?php
require_once 'Connection.php';

class UserDao
{
    public static function getUserByUsernamePassword($username, $password)
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT * FROM utente WHERE BINARY username = ? AND BINARY password = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            if ($stmt) {
                $stmt->bind_param("ss", $username, $password);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                return $user;
            } else {
                throw new Throwable("Error preparing statement: " . DBAccess::get_connection_state()->error);
            }
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function getUserByEmailPassword($email, $password)
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT * FROM utente WHERE BINARY email = ? AND BINARY password = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            if ($stmt) {
                $stmt->bind_param("ss", $email, $password);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                return $user;
            } else {
                throw new Throwable("Error preparing statement: " . DBAccess::get_connection_state()->error);
            }
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function createUser($username, $name, $surname, $email, $password)
    {
        try {
            DBAccess::open_connection();
            $query = "INSERT INTO utente (username, nome, cognome, email, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("sssss", $username, $name, $surname, $email, $password);
            $success = $stmt->execute();
            return $success;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }
}
?>