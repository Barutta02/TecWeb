<?php
try {
    require_once "Utility/utilities.php";
    require_once 'DAO/PiattoDAO.php';
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

try {
    $template = getTemplate('Layouts/main.html');
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

$pageID = 'menuCenaBody';
$title = "Menu Cena - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  <a href="index.php"><span lang="en">Home</span></a> >> Menu Cena</p> ';

$content = '';
$content .= get_prices_section('Cena', '20.10', '23.10');
$content .= '<section id="PiattiMenu" class="containerPlatesViewer"><h2>Piatti</h2>';
$content .= get_all_formatted_plates_Menu('Cena');
$content .= ' </section>';

session_start();
if (isset($_SESSION["username"])) {
    $template = str_replace('{{BottomMenu}}', str_replace('{{ListMenuBottom}}', get_bottom_menu_Login(), getTemplate('Layouts/bottomMenu.html')), $template);
    $menu = get_menu_Login();


} elseif (isset($_SESSION['adminLogged'])) {
    $menu = get_menu_Admin();
    $template = str_replace('{{BottomMenu}}', "", $template);
} else {
    $menu = get_menu_NoLogin();
    $template = str_replace('{{BottomMenu}}', "", $template);
}
$template = str_replace('{{menu}}', $menu, $template);

echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Menu cena Sushi Brombeis, menu cena all you can eat', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, "updateLinkWithSize('../assets/menu/MenuCena.pdf','downloadMenu')");
?>