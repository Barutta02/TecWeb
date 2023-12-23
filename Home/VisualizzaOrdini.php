<?php
require_once "Utility/utilities.php";
require_once 'DAO/PiattoDAO.php';
require_once 'DAO/CategoriaDAO.php';
require_once 'DAO/OrdineDAO.php';
require_once 'DAO/PrenotazioneDAO.php';


//Control login e di aver gia scelto numero di persone e tavolo
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
if (!isset($_SESSION["data_prenotazione_inCorso"])) {
    header("Location: prenotazione.php?MessageCode=6");
}


$template = getTemplate('Layouts/main.html');

$pageID = 'ViewOrdiniBody';
$title = "Visualizza ordini - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  <a href="index.php"><span lang="en">Home</span> </a> >> <a href="login.php"> Area utente</a> >> Visualizza ordini</p> ';

$content = "";


$content .= getThisPrenotationOrderView();


$content .= getFrequentView();




if (isset($_SESSION["username"])) {
    $template = str_replace('{{BottomMenu}}', str_replace('{{ListMenuBottom}}', get_bottom_menu_Login(), getTemplate('Layouts/bottomMenu.html')), $template);
    $menu = get_menu_Login();


} elseif (isset($_SESSION['adminLogged'])) {
    $template = str_replace('{{BottomMenu}}', str_replace('{{ListMenuBottom}}', get_bottom_menu_Login(), getTemplate('Layouts/bottomMenu.html')), $template);
    $menu = get_menu_Admin();
} else {
    $menu = get_menu_NoLogin();
    $template = str_replace('{{BottomMenu}}', "", $template);
}
$template = str_replace('{{menu}}', $menu, $template);

echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito
ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>