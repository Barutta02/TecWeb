<?php
require_once '../DAO/OrdineDAO.php';


// Gestione del form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    try {
        foreach ($_POST as $key => $value) {
            // Verifica se il campo inizia con "quantita_"
            if (strpos($key, 'quantita_') === 0) {
                $id = intval(str_replace('_', ' ', substr($key, 9)));
                $quantita = intval($value);
                if ($quantita > 0) {
                    OrdineDAO::createOrdine($id, $_SESSION['username'], date('Y-m-d H:i:s', time()), $_SESSION['data_prenotazione_inCorso'], $quantita);
                }
            }
        }
        header("Location: ../Prenota.php?ResponseCode=0");
        exit();
    } catch (Throwable $e) {
        header("Location: ../Prenota.php?ResponseCode=1");
        exit();
    }
}
header("Location: ../Prenota.php");
?>