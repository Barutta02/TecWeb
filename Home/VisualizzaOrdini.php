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
    header("Location: NuovaPrenotazione.php");
}


$template = getTemplate('Layouts/main.html');

$pageID = 'ViewOrdiniBody';
$title = "Visualizza ordini - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  Area utente>>Visualizza ordini</p> ';

$content = "";


$content .= getThisPrenotationOrderView();


$content .= getOldOrderView();




$menu = get_menu_Login();
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito
ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>