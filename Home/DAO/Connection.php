<?php

class DBAccess
{

    private static $HOST_DB = "127.0.0.1";
    private static $DATABASE_NAME = "sushirestaurant";
    #private static $DATABASE_NAME = "test";#dugoalberto

    private static $USERNAME = "root";
    private static $PASSWORD = "";
    private static $PORT = '3306';

    private static $connection;

    public static function open_connection()
    {

        mysqli_report(MYSQLI_REPORT_ERROR);

        self::$connection = new mysqli(self::$HOST_DB, self::$USERNAME, self::$PASSWORD, self::$DATABASE_NAME, self::$PORT);

        if (mysqli_connect_errno()) {
            echo getDBError();
            return false;
        } else {
            return true;
        }
    }

    public static function exec_select_query($query)
    {

        $res = $query->execute() or die(getDBError());

        if (mysqli_num_rows($res) == 0) {
            return array();
        } else {

            $resArray = array();

            while ($row = mysqli_fetch_assoc($res)) {
                array_push($resArray, $row);
            }

            $res->free();

            return $resArray;
        }
    }

    //Esegui query che alterano il sistema
    public static function exec_alter_query($query)
    {
        $res = mysqli_query(self::$connection, $query) or die(getDBError());
        return $res;
    }

    public static function close_connection()
    {
        if (self::$connection != null) {
            self::$connection->close();
        }
    }

    public static function get_connection_state()
    {
        return self::$connection;
    }


    public static function getDBError()
    {
        return "<p class='DBerror'>Errore di connessione al database</p>";
    }

}
?>