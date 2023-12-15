<?php

require_once "Utility/utilities.php";
require_once 'DAO/PiattoDAO.php';



$template = getTemplate('Layouts/main.html');


$pageID = 'menuCenaBody';
$title = "Menu Cena - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  Menu Cena</p> ';




$content = '';
$content .= get_prices_section('Cena', '20.10', '23.10');
;
$content .= '<section id="PiattiMenu" class="containerPlatesViewer"><h2>Plates</h2>';

$piattoDAO = new PiattoDAO();
$piatti = PiattoDAO::getAllPiatti();

$content .= get_all_formatted_plates_Menu($piatti);


$content .= ' </section>';


$menu = get_menu_NoLogin();
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>