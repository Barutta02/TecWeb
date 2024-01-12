<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $dataOra = isset($_POST['dataOra']) ? $_POST['dataOra'] : null;

    if ($username !== null && $dataOra !== null) {
        try {
            require_once '../DAO/PrenotazioneDAO.php';
            PrenotazioneDAO::TerminaPrenotazione($username, $dataOra);
        } catch (Throwable $th) {
            header('Location: ../500.html');
            exit(0);
        }
    } else {
        // Messaggio di errore se i dati non sono validi ==> error interno
        header('Location: ../500.html');
        exit(0);
    }
} else {
    // Messaggio di errore se la richiesta non è di tipo POST
    header("Location: ../signIn.php");
    exit();
}

?>