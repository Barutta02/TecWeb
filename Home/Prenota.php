<?php
require_once "Utility/utilities.php";
require_once "DAO/PrenotazioneDAO.php"; 

//Control login e di aver gia scelto numero di persone e tavolo
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
if (!isset($_SESSION["data_prenotazione_inCorso"])) {
    header("Location: prenotazione.php?MessageCode=5");
}

if(PrenotazioneDAO::getPrenotationByUsernameData($_SESSION["username"], $_SESSION['data_prenotazione_inCorso'])['stato']!='InCorso') {
    unset($_SESSION['data_prenotazione_inCorso']);
    header("Location: prenotazione.php?MessageCode=5");
    exit(0);
}

$template = getTemplate('Layouts/main.html');




$pageID = 'PrenotaBody';
$title = "Prenota piatti - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span></a> >> <a href="login.php">Area utente</a> >> Prenota</p> ';


//RaccogliWarning
$errorList = array();

if (isset($_GET['ResponseCode'])) {
    // Recupera il valore del parametro errorCode
    if ($_GET['ResponseCode'] == "0") {
        array_push($errorList, "<p class='good'>Ordinazione andata a buon fine.</p> ");
    }
    if ($_GET['ResponseCode'] == "1") {
        array_push($errorList, "<p class='warning'>Qualcosa è andato storto.</p> ");
    }
}




//PRENDO IL FORM PER LA SELEZIONE DEGLI ALLERGENI UTILITIES
$content = get_allergeni_form_section();

//PRENDO IL FORM PER LA  PRENOTAZIONE DEI PIATTI DA UTILITIES
$content .= ' <section id="PiattiMenu" class="containerPlatesViewer">
<h2 > ' . $_SESSION['name'] . ' ordina qui i tuoi piatti
</h2>' . implode(" ", $errorList) . get_prenotation_form_menu('process/process_prenotazione.php')
    . '</section>';



if (isset($_SESSION["username"])) {
    $template = str_replace('{{BottomMenu}}', str_replace('{{ListMenuBottom}}', get_bottom_menu_Login(), getTemplate('Layouts/bottomMenu.html')), $template);
    $menu = get_menu_Login();


} elseif (isset($_SESSION['adminLogged'])) {
    $menu = get_menu_ext_Admin();
} else {
    $menu = get_menu_NoLogin();
    $template = str_replace('{{BottomMenu}}', "", $template);
}
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Prenota da Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>