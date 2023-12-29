<?php
// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal modulo
    session_start();
    try {
        $username = $_SESSION['username'];
        $n_persone = $_POST["n_persone"];
        $indicazioniAggiuntive = $_POST["indicazioniAggiuntive"];
        $data = date('Y-m-d H:i:s', time());
        $in_corso = 'InCorso';
        require_once '../DAO/PrenotazioneDAO.php';
        require_once '../DAO/TavoloDAO.php';
        require_once '../Utility/utilities.php';
        if (empty($n_persone) || $n_persone <= 0) {
            header("Location: ../prenotazione.php?MessageCode=4");
        } else {
            $n_tavolo = PrenotazioneDAO::getTavoloForPrenotazione($n_persone);
            if ($n_tavolo) {
                PrenotazioneDAO::createPrenotazione($username, $data, $n_persone, sanitize_txt($indicazioniAggiuntive), $in_corso, $n_tavolo);
                $_SESSION['data_prenotazione_inCorso'] = $data;
                header("Location: ../prenotazione.php?MessageCode=1");
            } else {
                header("Location: ../prenotazione.php?MessageCode=3&n_posti=" . $n_persone);
            }

        }
    } catch (Throwable $th) {
        #header('Location: ../500.html');
        throw $th;
        exit();
    }
} else {
    // Se qualcuno tenta di accedere direttamente a questo file senza inviare il modulo, reindirizza alla pagina di registrazione
    header("Location: signIn.php");
    exit();
}

?>