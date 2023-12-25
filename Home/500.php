<?php

require_once "Utility/utilities.php";

//TEMPLATE comune
$templatePath = 'Layouts/main.html';
if (!file_exists($templatePath)) {
    die("Template file not found: $templatePath");
}
$template = file_get_contents($templatePath);
if ($template === false) {
    die("Failed to load template file: $templatePath");
}
$pageID = '500ID';
$title = "Error 500 - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: Un luogo in cui non dovresti trovarti</p> ';

//HTML statico dell'error 500
$html500 = 'Layouts/500Section.html';
if (!file_exists($html500)) {
    die("Template file not found: $html500");
}
$templatePres = file_get_contents($html500);
if ($templatePres === false) {
    die("Failed to load template file: $html500");
}

$content = '';

$content .= $templatePres;

session_start();
if (isset($_SESSION["username"])) {
    $template = str_replace('{{BottomMenu}}', str_replace('{{ListMenuBottom}}', get_bottom_menu_Login(), getTemplate('Layouts/bottomMenu.html')), $template);
    $menu = get_menu_Login();

} else {
    $menu = get_menu_NoLogin();
    $template = str_replace('{{BottomMenu}}', "", $template);
}
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>