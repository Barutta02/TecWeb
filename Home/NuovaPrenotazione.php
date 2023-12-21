<?php

require_once "Utility/utilities.php";

session_start();
//TEMPLATE comune
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

$n_tavolo = "";
$n_persone = "";
$operazione = "Crea nuova prenotazione";
if (isset($_SESSION['data_prenotazione_inCorso'])) {
    //Prendi i dati della prenotazione ovvero tavolo e numero di persone
    require_once "DAO/PrenotazioneDAO.php";
    $prenotazioneAttiva = PrenotazioneDAO::getPrenotationByUsernameData($_SESSION["username"], $_SESSION['data_prenotazione_inCorso']);
    $n_tavolo = $prenotazioneAttiva["Tavolo"];
    $n_persone = $prenotazioneAttiva["NumPersone"];
    $operazione = "Modifica";
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



$templatePren = str_replace('{{NumeroPersone}}', $n_persone, $templatePren);
$templatePren = str_replace('{{NumeroTavolo}}', $n_tavolo, $templatePren);
$templatePren = str_replace('{{Operazione}}', $operazione, $templatePren);

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