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
$breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span></a> &gt;&gt; <a href="login.php">Area utente</a> &gt;&gt; Gestione tavoli</p> ';
$content = "";

$content .= '<div class="flexable"><section id="SezioneGestioneTavoli"><h2>Stato occupazione tavoli</h2>' . get_table_avaible() . '</section>';
$content .= '<section id="SezioneGestionePrenotazioni"><h2>Prenotazioni attive</h2>';
$status = isset($_GET['MessageCode']) ? $_GET['MessageCode'] : null;
if ($status!=null && $status == 0) {
    $content .= '<p class="good">L&apos;operazione è andata a buon fine.</p>';
} elseif ($status == 1) {
    $content .= '<p class="warning">C&apos;è stato un errore nel tentativo di eseguire la richiesta. Operazione annullata.</p>';
} elseif($status!=null) {
    $content .= '<p class="warning">Errore sconosciuto.</p>';
}
$content .='<p class="info">Visualizza e gestisci qui le prenotazioni attive</p>' . get_active_prenotation() . '</section></div>';


echo render_page($template, $title, $pageID, $breadcrumbs, 'Gestione tavoli Sushi Brombeis, Prenotazioni ristorante sushi via brombeis', 'Gestisci i tavoli e le prenotazioni del ristorante Sushi Brombeis.', $content, '');
?>