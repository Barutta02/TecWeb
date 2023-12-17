<?php
require_once "Utility/utilities.php";
require_once 'DAO/OrdineDAO.php';

//Control login e di aver gia scelto numero di persone e tavolo
session_start();

if (!isset($_SESSION["adminLogged"]) || $_SESSION["adminLogged"] != 1) {
    header("Location: login.php");
}

//TEMPLATE MAIN
$template = getTemplate('Layouts/main.html');




$pageID = 'AdminPanelBody';
$title = "Pannello ristoratore - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  Pannello amministratore</p> ';


$content = '<section id="ordiniOdierni" class="containerPlatesViewer">
<h2> Piatti da fare </h2>';

$content .= toDoOrdersView();


$menu = get_menu_Admin();
$template = str_replace('{{menu}}', $menu, $template);
$template = str_replace('{{BottomMenu}}', "", $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>