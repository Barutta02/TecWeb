<?php

require_once "Utility/utilities.php";
require_once 'DAO/PiattoDAO.php';

$templatePath = 'Layouts/main.html';
if (!file_exists($templatePath)) {
    die("Template file not found: $templatePath");
}

$template = file_get_contents($templatePath);
if ($template === false) {
    die("Failed to load template file: $templatePath");
}

$pageID = 'menuCenaBody';
$title = "Menu Cena - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  Menu Pranzo</p> ';


$content = '';
$content .= get_prices_section('Pranzo', '14.10', '16.10');
$content .= '<section id="PiattiMenu" class="containerPlatesViewer"><h2>Plates</h2>';


$piattoDAO = new PiattoDAO();
$piatti = PiattoDAO::getPiattoByTipoMenu('Pranzo');
 
$content .= get_all_formatted_plates_Menu($piatti);

$content .= ' </section>';


$menu = get_menu_NoLogin();
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>