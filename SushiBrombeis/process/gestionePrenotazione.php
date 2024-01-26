<?php

try {
    require_once '../DAO/PrenotazioneDAO.php';
} catch (Throwable $th) {
    header('Location: ../500.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_utente = isset($_POST['username_utente']) ? $_POST['username_utente'] : null;
    $timestamp_prenotazione = isset($_POST['timestamp_prenotazione']) ? $_POST['timestamp_prenotazione'] : null;

    if ($_POST['action'] == 'Termina') {
        if ($username_utente !== null && $timestamp_prenotazione !== null) {
            try {
                PrenotazioneDAO::TerminaPrenotazione($username_utente, $timestamp_prenotazione);
                header('Location: ../freeTable.php?MessageCode=0');
                exit(0);
            } catch (Throwable $error) {
                header('Location: ../freeTable.php?MessageCode=1');
                exit();
            }
        }
        header('Location: ../freeTable.php?MessageCode=1');
        exit(0);

    } elseif ($_POST['action'] == 'Elimina') {
        session_start();
        $_SESSION['temp_delete_post_data'] = $_POST;
        header('Location: ../cancellaPrenotazione.php');
        exit(0);

    } elseif ($_POST['action'] == 'Annulla') {
        header('Location: ../freeTable.php');
        exit(0);

    } elseif ($_POST['action'] == 'Conferma') {
        if ($username_utente !== null && $timestamp_prenotazione !== null) {
            try {
                PrenotazioneDAO::EliminaPrenotazione($username_utente, $timestamp_prenotazione);
                header('Location: ../freeTable.php?MessageCode=0');
                exit(0);
            } catch (Throwable $th) {
                header('Location: ../freeTable.php?MessageCode=1');
                exit();
            }
        } 
        header('Location: ../freeTable.php?MessageCode=1');
        exit(0);
    } else {
        // Formulazione richiesta corretta, ma inesistente tra le opzioni
        header('Location: ../500.html');
        exit();
    }
} else {
    // Accesso illegale, torna in home
    header('Location: index.php');
}

?>