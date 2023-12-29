<?php
try {
    require_once "Utility/utilities.php";
    require_once 'DAO/PiattoDAO.php';

    $template = getTemplate('Layouts/main.html');
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

$pageID = 'menuPranzoBody';
$title = "Menu Pranzo - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span></a> >>  Menu Pranzo</p> ';

$content = '';
$content .= get_prices_section('Pranzo', '14.10', '16.10');
$content .= '<section id="PiattiMenu" class="containerPlatesViewer"><h2>Piatti</h2>';
$content .= get_all_formatted_plates_Menu('Pranzo');

$content .= ' </section>';



echo render_page($template, $title, $pageID, $breadcrumbs, 'Menu pranzo Sushi Brombeis, menu cena all you can eat', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, "updateLinkWithSize('../assets/menu/MenuPranzo.pdf','downloadMenu')");

?>