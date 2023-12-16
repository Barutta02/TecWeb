<?php
require_once "Utility/utilities.php";
session_start();
//TEMPLATE comune
$template = getTemplate('Layouts/main.html');

$pageID = 'homeID';
$title = "Home - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <span lang="en" aria-current="page">Home</span></p> ';


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



if (isset($_SESSION['username'])) {
    // L'utente è autenticato, ottieni il menu per utenti autenticati
    $menu = get_menu_Login_No_AreaUtente();
} else {
    // L'utente non è autenticato, ottieni il menu per utenti non autenticati
    $menu = get_menu_NoLogin();
}

$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>