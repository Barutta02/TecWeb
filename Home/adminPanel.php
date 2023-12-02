<?php
require_once "Utility/utilities.php";
require_once 'DAO/OrdineDAO.php';

//Control login e di aver gia scelto numero di persone e tavolo
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
if (!isset($_SESSION["adminLogged"]) || $_SESSION["adminLogged"] != 1) {
    header("Location: login.php");
} 

//TEMPLATE MAIN
$templatePath = 'Layouts/main.html';
if (!file_exists($templatePath)) {
    die("Template file not found: $templatePath");
}
$template = file_get_contents($templatePath);

//TEMPLATE ORDINAZIONI DA FARE
$templatePlatesAdminPath = 'Layouts/adminOrderManager.html';
if (!file_exists($templatePlatesAdminPath)) {
    die("Template file not found: $templatePlatesAdmin");
}
$templatePlatesAdmin = file_get_contents($templatePlatesAdminPath);


$pageID = 'AdminPanelBody';
$title = "Pannello ristoratore - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  Pannello amministratore</p> ';


$content = '<section id="ordiniOdierni" class="containerPlatesViewer">
<h2> Piatti da fare </h2>';

$ordineDAO = new OrdineDAO();
$piatti = OrdineDAO::getAllToDoOrder();
if (!empty($piatti)) {
    $content .= "<ul class='flexable'>";
    foreach ($piatti as $piatto) {
        $refactorNomePiatto = str_replace(' ', '_', strtolower($piatto['NomePiatto']));
        $templatePlatesInputIter = $templatePlatesAdmin;
        $templatePlatesInputIter = str_replace('{{NomePiattoUnderscored}}', $refactorNomePiatto, $templatePlatesInputIter);
        $templatePlatesInputIter = str_replace('{{NomePiatto}}', $piatto['NomePiatto'], $templatePlatesInputIter);
        $templatePlatesInputIter = str_replace('{{Descrizione}}', $piatto['Descrizione'], $templatePlatesInputIter);
        $templatePlatesInputIter = str_replace('{{Quantita}}', $piatto['Quantita'], $templatePlatesInputIter);
        $templatePlatesInputIter = str_replace('{{IdPiatto}}', $piatto['IDPiatto'], $templatePlatesInputIter);
        $templatePlatesInputIter = str_replace('{{Orario}}', $piatto['Dataora'], $templatePlatesInputIter);
        $templatePlatesInputIter = str_replace('{{Cliente}}', $piatto['cliente'], $templatePlatesInputIter);
        $content .= $templatePlatesInputIter;
    }
    $content .= "</ul>";
} else {
    $content .= "Devono ancora effettuare ordinazioni.";
}


$menu = get_menu_Admin();
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>