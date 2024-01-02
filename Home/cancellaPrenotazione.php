<?php
try {
    require_once "Utility/utilities.php";
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

if (
    (!isset($_SESSION["adminLogged"]) || $_SESSION["adminLogged"] != 1) &&
    isset($_SERVER['REQUEST_METHOD'])
) {
    # Recupera la sessione creata da gestionePrenotazione.php 
    session_start();
    $_POST = isset($_SESSION['temp_delete_post_data']) ? $_SESSION['temp_delete_post_data'] : null;

    # Tentativo di un accesso illegale alla pagina
    if ($_POST == null) {
        header('Location: index.php');
        exit(0);
    }

    try {
        $template = getTemplate('Layouts/main.html');
    } catch (Throwable $th) {
        header('Location: 500.html');
        exit(0);
    }

    try {
        $content = getTemplate('Layouts/confermaEliminazione.html');
    } catch (Throwable $th) {
        $content = get_error_msg();
    }

    unset($_SESSION['temp_delete_post_data']); # Cleanup per sicurezza

    $pageID = 'cancellaPrenotazione';
    $title = "Cancella prenotazione - Sushi Brombeis";
    $breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span> </a> >> <a href="login.php"> Area utente</a> >> <a href="freeTable.php">Gestione tavoli</a> >> Eliminazione Prenotazione</p>';

    try {
        $content = getTemplate('Layouts/confermaEliminazione.html');
    } catch (Throwable $th) {
        $content = get_error_msg();
    }

    $content = str_replace('{{numero_tavolo}}', $_POST['numero_tavolo'], $content);
    $content = str_replace('{{timestamp_prenotazione}}', $_POST['timestamp_prenotazione'], $content);
    $content = str_replace('{{username_utente}}', $_POST['username_utente'], $content);

    echo render_page($template, $title, $pageID, $breadcrumbs, 'Cancella prenotazione', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');

} else {
    # Qualcuno sta cercando di accedere a questa pagina in un modo non previsto, redirigo alla pagina Home
    header('Location: index.php');
}
?>