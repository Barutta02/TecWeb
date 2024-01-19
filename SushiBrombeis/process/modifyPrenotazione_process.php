<?php
// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal modulo
    session_start();
    $username = $_SESSION['username'];
    $indicazioniAggiuntive = $_POST["indicazioniAggiuntive"];
    try {
        if (isset($_SESSION['data_prenotazione_inCorso'])) {
            require_once '../DAO/PrenotazioneDAO.php';
            require_once '../Utility/utilities.php';
            PrenotazioneDAO::updatePrenotazione($username, $_SESSION['data_prenotazione_inCorso'], sanitize_txt($indicazioniAggiuntive));
            header("Location: ../prenotazione.php?MessageCode=2");
            exit();
        } else {
            header("Location: ../prenotazione.php?MessageCode=9");
            exit();
        }
    } catch (Throwable $th) {
        header('Location: ../500.html');
        exit();
    }

} else {
    // Se qualcuno tenta di accedere direttamente a questo file senza inviare il modulo, reindirizza alla pagina di registrazione
    header("Location: ../signIn.php");
    exit();
}

?>