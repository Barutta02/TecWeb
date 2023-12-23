<?php
#session_start();
require_once "Utility/utilities.php";


//TEMPLATE comune

$template = getTemplate('Layouts/main.html');

$pageID = 'chiSiamoID';
$title = "Chi siamo - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span> </a> >> Chi siamo</p> ';


//Sezione di presentazione del ristorante
$sectionPresentation = 'Layouts/chiSiamo.html';
if (!file_exists($sectionPresentation)) {
    die("Template file not found: $sectionPresentation");
}
$templatePres = file_get_contents($sectionPresentation);
if ($templatePres === false) {
    die("Failed to load template file: $templatePres");
}


$content = '';


$content .= $templatePres;



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

echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>