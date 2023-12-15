<?php
require_once "Utility/utilities.php";

//Control login e di aver gia scelto numero di persone e tavolo
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
if (!isset($_SESSION["data_prenotazione_inCorso"])) {
    header("Location: NuovaPrenotazione.php");
}


$template = getTemplate('Layouts/main.html');




$pageID = 'PrenotaBody';
$title = "Prenota piatti - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  Area utente>>Prenota</p> ';

//PRENDO IL FORM PER LA SELEZIONE DEGLI ALLERGENI UTILITIES
$content = get_allergeni_form_section();

//PRENDO IL FORM PER LA  PRENOTAZIONE DEI PIATTI DA UTILITIES
$content .= ' <section id="PiattiMenu" class="containerPlatesViewer">
<h2 > ' . $_SESSION['name'] . ' ordina qui i tuoi piatti
</h2>' . get_prenotation_form_menu('process/process_prenotazione.php')
    . '</section>';


$menu = get_menu_Login();
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>