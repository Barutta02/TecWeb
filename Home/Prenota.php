<?php

try {
    require_once "Utility/utilities.php";
    require_once "DAO/PrenotazioneDAO.php";
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}
//Control login e di aver gia scelto numero di persone e tavolo
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
if (empty($_SESSION['data_prenotazione_inCorso'])) {
    header("Location: prenotazione.php?MessageCode=5");
    exit();
}

try {
    $prenotazione = PrenotazioneDAO::getPrenotationByUsernameData($_SESSION["username"], $_SESSION['data_prenotazione_inCorso']);
    if (empty($prenotazione)) {
        $_SESSION['data_prenotazione_inCorso'] = null;
        header('Location: prenotazione.php?MessageCode=8');
        exit(0);
    } elseif ($prenotazione['stato'] != 'InCorso') {
        $_SESSION['data_prenotazione_inCorso'] = null;
        header('Location: prenotazione.php?MessageCode=7');
        exit(0);
    }
    $template = getTemplate('Layouts/main.html');
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

$pageID = 'PrenotaBody';
$title = "Prenota piatti - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span></a> >> <a href="login.php">Area utente</a> >> Ordina</p> ';

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





echo render_page($template, $title, $pageID, $breadcrumbs, 'Prenota da Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>