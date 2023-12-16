<?php

require_once "Utility/utilities.php";


//TEMPLATE comune
$template = getTemplate('Layouts/main.html');

$pageID = 'homeID';
$title = "Home - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <span lang="en">Home</span></p> ';


//Sezione di presentazione del ristorante
$sectionPresentation = 'Layouts/presentationSection.html';
if (!file_exists($sectionPresentation)) {
    die("Template file not found: $sectionPresentation");
}
$templatePres = file_get_contents($sectionPresentation);
if ($templatePres === false) {
    die("Failed to load template file: $templatePres");
}


$content = '';

$content .= $templatePres;


$menu = get_menu_NoLogin();
$template = str_replace('{{menu}}', $menu, $template);

session_start();
if (isset($_SESSION["username"])) {
    $template = str_replace('{{BottomMenu}}', str_replace('{{ListMenuBottom}}', get_bottom_menu_Login(), getTemplate('Layouts/bottomMenu.html')), $template);
} else {
    $template = str_replace('{{BottomMenu}}', "", $template);
}

echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>