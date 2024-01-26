<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera i dati dalla richiesta POST
    $id_piatto = isset($_POST['ID_piatto']) ? $_POST['ID_piatto'] : null;
    $username = isset($_POST['cliente']) ? $_POST['cliente'] : null;
    $dataOraOrdine = isset($_POST['orario_ordine']) ? $_POST['orario_ordine'] : null;
    $nuovoStatoConsegnato = 1;

    // Validazione dei dati (puoi implementare ulteriori controlli a seconda delle tue esigenze)

    if ($id_piatto !== null && $username !== null && $dataOraOrdine !== null && $nuovoStatoConsegnato !== null) {
        // Connessione al database
        try {
            require_once '../DAO/OrdineDAO.php';
            OrdineDAO::aggiornaStatoConsegna($id_piatto, $username, $dataOraOrdine, $nuovoStatoConsegnato);
        } catch (Throwable $th) {
            header('Location: ../500.html');
            exit();
        }
        header('Location: ../adminPanel.php?MessageCode=1');
        exit();
    } else {
        // Messaggio di errore se i dati non sono validi
        header('Location: ../adminPanel.php?MessageCode=2');
        exit();
    }
} else {
    // Messaggio di errore se la richiesta non è di tipo POST
    header("Location: ../signIn.php");
    exit();
}

?>
