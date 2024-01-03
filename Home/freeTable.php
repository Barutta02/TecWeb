<?php
try {
    require_once "Utility/utilities.php";
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

//Control login e di aver gia scelto numero di persone e tavolo
session_start();
if (!isset($_SESSION["adminLogged"]) || $_SESSION["adminLogged"] != 1) {
    header("Location: login.php");
}

try {
    $template = getTemplate('Layouts/main.html');
} catch (Throwable $th) {
    header('Location: 500.html');
}

$pageID = 'GestioneTavoli';
$title = "Gestione tavoli - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span></a> >> <a href="login.php">Area utente</a> >> Gestione tavoli</p> ';

#Msg error (temporaneo, converite alla stessa tipologia di errore dell'area utente)
$status = isset($_GET['StatusCode']) ? $_GET['StatusCode'] : null;
if ($status == null) {
    $content = "";
} elseif ($status == 0) {
    $content = '<p class="good">L&apos;operazione è andata a buon fine.</p>';
} elseif ($status == 1) {
    $content = '<p class="warning">C&apos;è stato un errore nel tentativo di eseguire la richiesta. L&apos;operazione è stata annullata.</p>';
}

//PRENDO IL FORM PER LA SELEZIONE DEGLI ALLERGENI UTILITIES
$content .= '<div class="flexable"><section id="SezioneGestioneTavoli"><h2>Stato occupazione tavoli</h2>' . get_table_avaible() . '</section>';
$content .= '<section id="SezioneGestionePrenotazioni"><h2>Prenotazioni attive</h2><p class="info">Visualizza e gestisci qui le prenotazioni attive</p>' . get_active_prenotation() . '</section></div>';


//PRENDO IL FORM PER LA  PRENOTAZIONE DEI PIATTI DA UTILITIES



echo render_page($template, $title, $pageID, $breadcrumbs, 'Prenotazione tavolo da Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>