<?php

require_once "Utility/utilities.php";
require_once 'DAO/PiattoDAO.php';


$template = getTemplate('Layouts/main.html');



$pageID = 'menuPranzoBody';
$title = "Menu Pranzo - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span></a> >>  Menu Pranzo</p> ';


$content = '';
$content .= get_prices_section('Pranzo', '14.10', '16.10');
$content .= '<section id="PiattiMenu" class="containerPlatesViewer"><h2>Piatti</h2>';


$piatti = PiattoDAO::getPiattoByTipoMenu('Pranzo');

$content .= get_all_formatted_plates_Menu($piatti);

$content .= ' </section>';


session_start();
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

echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Menu pranzo Sushi Brombeis, menu cena all you can eat', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, "updateLinkWithSize('../assets/menu/MenuPranzo.pdf','downloadMenu')");
?>