<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera i dati dalla richiesta POST
    $idPiatto = isset($_POST['idPiatto']) ? $_POST['idPiatto'] : null;
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $dataOraOrdine = isset($_POST['dataOraOrdine']) ? $_POST['dataOraOrdine'] : null;
    $nuovoStatoConsegnato = isset($_POST['nuovoStatoConsegnato']) ? $_POST['nuovoStatoConsegnato'] : null;

    // Validazione dei dati (puoi implementare ulteriori controlli a seconda delle tue esigenze)

    if ($idPiatto !== null && $username !== null && $dataOraOrdine !== null && $nuovoStatoConsegnato !== null) {
        // Connessione al database
        try {
            require_once '../DAO/OrdineDAO.php';
            $ordineDAO = new OrdineDAO();
            OrdineDAO::aggiornaStatoConsegna($idPiatto, $username, $dataOraOrdine, $nuovoStatoConsegnato);
        } catch (Throwable $th) {
            header('Location: 500.php');
            exit();
        }

    } else {
        // Messaggio di errore se i dati non sono validi
        #??????
        echo "Errore: Dati non validi";
    }
} else {
    // Messaggio di errore se la richiesta non è di tipo POST
    #????
    echo "Errore: Richiesta non valida";
}

?>
