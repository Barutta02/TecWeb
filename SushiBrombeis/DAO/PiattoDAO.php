<?php
require_once 'Connection.php';

class PiattoDAO
{
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
            if (!$stmt) {
                throw new Throwable('Error in query preparation: ' . DBAccess::get_connection_state()->error);
            }
            $stmt->bind_param('s', $tipo);
            $stmt->execute();
            $result = $stmt->get_result();
            if (!$result) {
                throw new Throwable();
            }
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } finally {
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
            if (!$stmt) {
                throw new Throwable();
            }
            $stmt->bind_param('s', $categoria);
            $stmt->execute();
            $result = $stmt->get_result();
            if (!$result) {
                throw new Throwable();
            }
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } finally {
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
            DBAccess::close_connection();
        }
    }
}
?>