<?php

try {
    require_once "Utility/utilities.php";
    require_once 'DAO/PiattoDAO.php';
    require_once 'DAO/CategoriaDAO.php';
    require_once 'DAO/OrdineDAO.php';
    require_once 'DAO/PrenotazioneDAO.php';
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
if (empty($_SESSION["data_prenotazione_inCorso"])) {
    header("Location: prenotazione.php?MessageCode=6");
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
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

try {
    $template = getTemplate('Layouts/main.html');
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

$pageID = 'ViewOrdiniBody';
$title = "Visualizza ordini - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  <a href="index.php"><span lang="en">Home</span></a> &gt;&gt; <a href="login.php">Area utente</a> &gt;&gt; I miei ordini</p> ';

$content = "";
$content .= getThisPrenotationOrderView();
$content .= getFrequentView();


echo render_page($template, $title, $pageID, $breadcrumbs, 'I tuoi ordini da Sushi Brombeis, Ordini ristorante sushi via brombeis', 'Visualizza gli ordini
che più hai preferito nel ristorante sushi all you can eat a Napoli!', $content, '');
?>