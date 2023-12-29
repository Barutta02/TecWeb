<?php
try {
    require_once "Utility/utilities.php";
    require_once 'DAO/OrdineDAO.php';
} catch (Throwable $th) {
    header('Location: 500.php');
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
    header('Location: 500.php');
    exit(0);
}

$pageID = 'AdminPanelBody';
$title = "Pannello ristoratore - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span> </a> >> <a href="login.php"> Area utente</a> >> Pannello amministratore</p> ';

$content = '<section id="piattiDaFare" class="containerPlatesViewer">
<h2> Piatti da fare </h2>';

$content .= toDoOrdersView();
$content .= '</section>';
$menu = get_menu_Admin();
$template = str_replace('{{menu}}', $menu, $template);
$template = str_replace('{{BottomMenu}}', "", $template);

echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '', "Admin");
?>