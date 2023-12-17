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
$pageID = '404ID';
$title = "Error 404 - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: Un luogo in cui non dovresti trovarti</p> ';

//HTML statico dell'error 404
$html404 = 'Layouts/404Section.html';
if (!file_exists($html404)) {
    die("Template file not found: $html404");
}
$templatePres = file_get_contents($html404);
if ($templatePres === false) {
    die("Failed to load template file: $html404");
}

$content = '';

$content .= $templatePres;

$menu = get_menu_NoLogin();
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>