<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera i dati dalla richiesta POST
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $dataOra = isset($_POST['dataOra']) ? $_POST['dataOra'] : null;
    // Validazione dei dati (puoi implementare ulteriori controlli a seconda delle tue esigenze)

    if ($username !== null && $dataOra !== null) {
        // Connessione al database
        require_once '../DAO/PrenotazioneDAO.php';

        PrenotazioneDAO::TerminaPrenotazione($username, $dataOra);

    } else {
        // Messaggio di errore se i dati non sono validi
        echo "Errore: Dati non validi";
    }
} else {
    // Messaggio di errore se la richiesta non è di tipo POST
    echo "Errore: Richiesta non valida";
}

?>