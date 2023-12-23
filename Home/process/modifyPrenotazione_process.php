<?php
// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal modulo
    session_start();
    $username = $_SESSION['username'];
    $indicazioniAggiuntive = $_POST["indicazioniAggiuntive"];
    if (isset($_SESSION['data_prenotazione_inCorso'])) {
        require_once '../DAO/PrenotazioneDAO.php';
        PrenotazioneDAO::updatePrenotazione($username, $_SESSION['data_prenotazione_inCorso'], $indicazioniAggiuntive);
        header("Location: ../prenotazione.php?MessageCode=2");
    } else {
        echo "TODO";
    }

} else {
    // Se qualcuno tenta di accedere direttamente a questo file senza inviare il modulo, reindirizza alla pagina di registrazione
    //header("Location: signIn.php");
    exit();
}

?>