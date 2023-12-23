<?php
require_once "Utility/utilities.php";

//Control login e di aver gia scelto numero di persone e tavolo
session_start();
if (!isset($_SESSION["adminLogged"]) || $_SESSION["adminLogged"] != 1) {
    header("Location: login.php");
}

$template = getTemplate('Layouts/main.html');




$pageID = 'GestioneTavoli';
$title = "Gestione tavoli - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span> </a> >> <a href="login.php"> Area utente</a> >> Gestione tavoli</p> ';

//PRENDO IL FORM PER LA SELEZIONE DEGLI ALLERGENI UTILITIES
$content = '<div class="flexable"><section id="SezioneGestioneTavoli"><h2>Gestione tavoli</h2>' . get_table_avaible() . '</section>';
$content .= '<section id="SezioneGestionePrenotazioni"><h2>Prenotazioni attive</h2>' . get_active_prenotation() . '</section></div>';


//PRENDO IL FORM PER LA  PRENOTAZIONE DEI PIATTI DA UTILITIES



$menu = get_menu_Admin();
$template = str_replace('{{menu}}', $menu, $template);
$template = str_replace('{{BottomMenu}}', "", $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '', "Admin");
?>