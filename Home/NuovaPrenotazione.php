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
$pageID = 'newPrenotationId';
$title = "Nuova Prenotazione - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: Area utente>>Gestisci prenotazione</p> ';


//Sezione di presentazione del ristorante
$sectionPrenotazione = 'Layouts/NuovaPrenotazioneSection.html';
if (!file_exists($sectionPrenotazione)) {
    die("Template file not found: $sectionPrenotazione");
}
$templatePren = file_get_contents($sectionPrenotazione);
if ($templatePren === false) {
    die("Failed to load template file: $sectionPrenotazione");
}


$content = '';

$content .= $templatePren;


$menu = get_menu_Login();
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>