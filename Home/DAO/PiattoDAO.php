<?php
require_once 'Connection.php';

class PiattoDAO
{
    /*
    CREATE TABLE piatto (
        id                 INT PRIMARY KEY AUTO_INCREMENT,
        nome               VARCHAR(100) NOT NULL,
        descrizione        VARCHAR(100), -- maybe?
        categoria          VARCHAR(20) NOT NULL,
        prezzo             DECIMAL(5,2) NOT NULL CHECK (prezzo >= 0),
        tipologia_menu     ENUM('Pranzo', 'Cena', 'Entrambi') NOT NULL,
        tipologia_portata  ENUM('AllYouCanEat', 'AllaCarta') NOT NULL
    );*/
    public static function getPiattoById($id)
    {
        try {
            DBAccess::open_connection();
            $query = "SELECT * FROM piatto WHERE id = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();

            $result = $stmt->get_result();
            return $result->fetch_assoc();
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
        if (self::isTimeForDinner()) {
            return self::getPiattoByTipoCategory_TipoMenu($categoria, "Cena");
        } else {
            return self::getPiattoByTipoCategory_TipoMenu($categoria, "Pranzo");
        }
    }

    public static function getPiattoByTipoMenu($tipo)
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT * FROM piatto WHERE tipologia_menu = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);

            // Check for errors in preparing the statement
            if (!$stmt) {
                throw new Throwable('Error in query preparation: ' . DBAccess::get_connection_state()->error);
            }

            // Bind the parameter
            $stmt->bind_param('s', $tipo);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result set from the executed statement
            $result = $stmt->get_result();

            // Check for errors in executing the statement
            if (!$result) {
                throw new Throwable();
            }

            $rows = [];

            // Fetch the data from the result set
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
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
                $query = "SELECT * FROM piatto WHERE categoria = ?";

            } else {
                $query = "SELECT * FROM piatto WHERE categoria = ? and tipologia_menu = 'Pranzo'";
            }
            $stmt = DBAccess::get_connection_state()->prepare($query);
            // Check for errors in preparing the statement
            if (!$stmt) {
                throw new Throwable();
            }

            // Bind the parameter
            $stmt->bind_param('s', $categoria);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result set from the executed statement
            $result = $stmt->get_result();

            // Check for errors in executing the statement
            if (!$result) {
                throw new Throwable();
            }

            $rows = [];

            // Fetch the data from the result set
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        } finally {
            // Ensure the database connection is always closed
            DBAccess::close_connection();
        }
    }

    public static function getAllPiatti()
    {
        try {
            DBAccess::open_connection();

            $query = "SELECT * FROM piatto";
            $result = DBAccess::get_connection_state()->query($query);

            if ($result) {
                $rows = [];
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }

                return $rows;
            } else {
                throw new Throwable();
            }
        } finally {
            // Ensure the database connection is always closed
            DBAccess::close_connection();
        }
    }

    public static function addPiatto($nome, $descrizione, $prezzo, $tipoMenu, $tipoPortata)
    {
        try {
            DBAccess::open_connection();

            $query = "INSERT INTO piatto (nome, descrizione, prezzo, tipologia_menu, TipoPortata) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bind_param('ssdss', $nome, $descrizione, $prezzo, $tipoMenu, $tipoPortata);

            return $stmt->execute();
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

            $query = "UPDATE piatto SET nomepiatto = ?, descrizione = ?, prezzo = ?, tipologia_menu = ?, tipologia_portata = ? WHERE id = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bindParam(1, $nome);
            $stmt->bindParam(2, $descrizione);
            $stmt->bindParam(3, $prezzo);
            $stmt->bindParam(4, $tipoMenu);
            $stmt->bindParam(5, $tipoPortata);
            $stmt->bindParam(6, $id);

            return $stmt->execute();
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
            $query = "DELETE FROM piatto WHERE id = ?";
            $stmt = DBAccess::get_connection_state()->prepare($query);
            $stmt->bindParam(1, $id);

            return $stmt->execute();
        } finally {
            // Ensure the database connection is always closed
            DBAccess::close_connection();
        }
    }
}
?>