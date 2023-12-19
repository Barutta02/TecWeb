<?php

require_once "Utility/utilities.php";

session_start();
//TEMPLATE comune
if (!isset($_SESSION["username"])) {
    header("Location: login.php");

}
$template = getTemplate('Layouts/main.html');

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