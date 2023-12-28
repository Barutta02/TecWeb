<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera i dati dalla richiesta POST
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $dataOra = isset($_POST['dataOra']) ? $_POST['dataOra'] : null;
    // Validazione dei dati (puoi implementare ulteriori controlli a seconda delle tue esigenze)

    if ($username !== null && $dataOra !== null) {
        // Connessione al database
        try {
            require_once '../DAO/PrenotazioneDAO.php';
            PrenotazioneDAO::TerminaPrenotazione($username, $dataOra);
        } catch (Throwable $th) {
            header('Location: 500.php');
            exit(0);
        }

    } else {
        // Messaggio di errore se i dati non sono validi
        # BOOOHHH, qui che ci va?
        echo "Errore: Dati non validi";
    }
} else {
    // Messaggio di errore se la richiesta non è di tipo POST
    echo "Errore: Richiesta non valida";
}

?>