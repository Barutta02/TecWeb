<?php

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $username_utente = isset($_POST['username_utente']) ? $_POST['username_utente'] : null;
    $timestamp_prenotazione = isset($_POST['timestamp_prenotazione']) ? $_POST['timestamp_prenotazione'] : null;
    
    if ($_POST['action']=='Termina') {
        if ($username_utente !== null && $timestamp_prenotazione !== null) {
            require_once '../DAO/PrenotazioneDAO.php';
            try {
                PrenotazioneDAO::TerminaPrenotazione($username_utente,$timestamp_prenotazione);
                header('Location: ../freeTable.php?StatusCode=0');
                exit(0);
            } catch (Exception $error) {}
        }
        header('Location: ../freeTable.php?StatusCode=1');
        exit(0);
    
    } elseif ($_POST['action']=='Elimina') {
        session_start();
        $_SESSION['temp_delete_post_data'] = $_POST;
        header('Location: ../cancellaPrenotazione.php');
        exit(0);

    } elseif ($_POST['action']=='Annulla') {
        header('Location: ../freeTable.php');
        exit(0);

    } elseif ($_POST['action']=='Conferma') {
        if ($username_utente !== null && $timestamp_prenotazione !== null) {
            require_once '../DAO/PrenotazioneDAO.php';
            PrenotazioneDAO::EliminaPrenotazione($username_utente, $timestamp_prenotazione);
            header('Location: ../freeTable.php?StatusCode=0');
            exit(0);
        } else {
            header('Location: ../freeTable.php?StatusCode=1');
            exit(0);
        }
    } else {

    } 
} else {
    echo "Richiesta non valida";
}

?>