<?php
// Assicurati di avere accesso alle classi e ai metodi necessari
require_once '../DAO/OrdineDAO.php';


// Gestione del form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    // Crea un array per memorizzare i dati della prenotazione
    // Estrai i dati dalla richiesta POST
    foreach ($_POST as $key => $value) {
        // Verifica se il campo inizia con "quantita_"
        if (strpos($key, 'quantita_') === 0) {
            echo ($_SESSION['data_prenotazione_inCorso']);
            $id = intval(str_replace('_', ' ', substr($key, 9)));
            $quantita = intval($value);
            if ($quantita > 0) {
                $ordineDAO = new OrdineDAO();
                OrdineDAO::createOrdine($id, $_SESSION['username'], date('Y-m-d H:i:s', time()), $_SESSION['data_prenotazione_inCorso'], $quantita);
            }


        }
    }
}
header("Location: prenota.php");


?>