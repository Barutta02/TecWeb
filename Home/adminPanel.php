<?php
try {
    require_once "Utility/utilities.php";
    require_once 'DAO/OrdineDAO.php';
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

//Control login e di aver gia scelto numero di persone e tavolo
session_start();

if (!isset($_SESSION["adminLogged"]) || $_SESSION["adminLogged"] != 1) {
    header("Location: login.php");
}

//TEMPLATE MAIN
try {
    $template = getTemplate('Layouts/main.html');
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

$pageID = 'AdminPanelBody';
$title = "Pannello ristoratore - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span> </a> &gt;&gt; <a href="login.php"> Area utente</a> &gt;&gt; Pannello amministratore</p> ';

$content = '<section id="piattiDaFare" class="containerPlatesViewer">
<h2> Piatti da fare </h2>
<p class="info">Visualizza qui i piatti ordinati, clicca su "Fatto" quando sono pronti.</p>';

$content .= toDoOrdersView();
$content .= '</section>';


echo render_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Pagina amministratore del sito di sushi Brombeis a Napoli.', $content, '');
?>