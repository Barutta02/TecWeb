<?php
require_once 'Connection.php';

class UserDao
{
    /**CREATE TABLE utente (
        username    VARCHAR(50) PRIMARY KEY,
        email       VARCHAR(100) CHECK (email LIKE '%@%.%'),
        nome        VARCHAR(50) NOT NULL,
        cognome     VARCHAR(50) NOT NULL,
        password    VARCHAR(255) NOT NULL CHECK (length(password) >= 4),
        privilegi   ENUM('Cliente', 'Admin') DEFAULT 'Cliente'
    ); */
    public static function getUserByUsername($username)
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT * FROM utente WHERE username = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            return $user;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function getUserByUsernamePassword($username, $password)
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT * FROM utente WHERE username = ? AND password = ?";
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
            $query = "SELECT * FROM utente WHERE email = ? AND password = ?";
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

    public static function updateUser($username, $name, $surname, $email, $password)
    {
        try {
            DBAccess::open_connection();
            $query = "UPDATE utente SET nome=?, cognome=?, email=?, password=? WHERE username=?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("sssss", $name, $surname, $email, $password, $username);
            $success = $stmt->execute();
            return $success;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            DBAccess::close_connection();
        }
    }

    public static function deleteUser($username)
    {
        try {
            DBAccess::open_connection();
            $query = "DELETE FROM utente WHERE username=?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param("s", $username);
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