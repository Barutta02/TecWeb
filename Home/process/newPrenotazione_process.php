<?php
// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal modulo
    session_start();
    $username = $_SESSION['username'];
    $n_tavolo = $_POST["n_tavolo"];
    $n_persone = $_POST["n_persone"];
    $data = date('Y-m-d H:i:s', time());
    $in_corso = true;
    require_once '../DAO/PrenotazioneDAO.php';
    //SE la prenotazione era gia attiva la sta modificando
    if (isset($_SESSION['data_prenotazione_inCorso'])) {
        PrenotazioneDAO::updatePrenotazione($username, $_SESSION['data_prenotazione_inCorso'], $n_persone, $n_tavolo);
        header("Location: ../NuovaPrenotazione.php");
    } else {

        // Esempio di validazione (puoi personalizzarla in base alle tue esigenze)
        if (empty($username) || empty($n_tavolo) || empty($n_persone)) {
            echo "Compila tutti i campi del modulo.";
        } else {

            $prenotazioneDAO = new PrenotazioneDAO();
            PrenotazioneDAO::createPrenotazione($username, $data, $n_persone, $in_corso, $n_tavolo);

            $_SESSION['data_prenotazione_inCorso'] = $data;
            header("Location: ../Prenota.php");
        }

    }

} else {
    // Se qualcuno tenta di accedere direttamente a questo file senza inviare il modulo, reindirizza alla pagina di registrazione
    //header("Location: signIn.php");
    exit();
}

?>