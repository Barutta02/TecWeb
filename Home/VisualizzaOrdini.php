<?php
require_once "Utility/utilities.php";
require_once 'DAO/PiattoDAO.php';
require_once 'DAO/CategoriaDAO.php';
require_once 'DAO/OrdineDAO.php';
require_once 'DAO/PrenotazioneDAO.php';


//Control login e di aver gia scelto numero di persone e tavolo
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
if (!isset($_SESSION["data_prenotazione_inCorso"])) {
    header("Location: NuovaPrenotazione.php");
}

$platesQuanityConsegnatilayoutPath = 'Layouts/MenuItemViewQuantityConsegnato.html';
$platesQuanitylayoutPath = 'Layouts/MenuItemViewQuantity.html';

$templatePath = 'Layouts/main.html';

if (!file_exists($templatePath)) {
    die("Template file not found: $templatePath");
}
$template = file_get_contents($templatePath);


$templatePlatesQC = file_get_contents($platesQuanityConsegnatilayoutPath);
if ($templatePlatesQC === false) {
    die("Failed to load template file: $platesQuanityConsegnatilayoutPath");
}

$templatePlatesQ = file_get_contents($platesQuanitylayoutPath);
if ($templatePlatesQ === false) {
    die("Failed to load template file: $platesQuanitylayoutPath");
}

$pageID = 'ViewOrdiniBody';
$title = "Visualizza ordini - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  Area utente>>Visualizza ordini</p> ';


$content = '<section id="ordiniOdierni" class="containerPlatesViewer">
<h2 >' . $_SESSION['name'] . ' questi sono i piatti che hai ordinato oggi
</h2>';

$ordineDAO = new OrdineDAO();
$piatti = OrdineDAO::getOrdineByPrenotazione($_SESSION['username'], $_SESSION['data_prenotazione_inCorso']);
if (!empty($piatti)) {
    $content .= "<ul class='flexable'>";
    foreach ($piatti as $piatto) {
        $refactorNomePiatto = str_replace(' ', '', strtolower($piatto['NomePiatto']));
        $templatePlatesInputIter = $templatePlatesQC;
        $templatePlatesInputIter = str_replace('{{NomePiattoUnderscored}}', $refactorNomePiatto, $templatePlatesInputIter);
        $templatePlatesInputIter = str_replace('{{NomePiatto}}', $piatto['NomePiatto'], $templatePlatesInputIter);
        $templatePlatesInputIter = str_replace('{{Descrizione}}', $piatto['Descrizione'], $templatePlatesInputIter);
        $templatePlatesInputIter = str_replace('{{Quantita}}', $piatto['Quantita'], $templatePlatesInputIter);
        $templatePlatesInputIter = str_replace('{{isConsegnato}}', (($piatto['isConsegnato'] == true) ? "Si" : "No"), $templatePlatesInputIter);
        $content .= $templatePlatesInputIter;
    }
    $content .= "</ul>";
} else {
    $content .= "Devi ancora effettuare ordinazioni oggi " . $_SESSION['name'] . '.';
}

$content .= '</section>';

$prenotazioneDAO = new PrenotazioneDAO();
$prenotazioniPassate = PrenotazioneDAO::getOldPrenotazioniByUsername($_SESSION['username'], $_SESSION['data_prenotazione_inCorso']);
if (!empty($prenotazioniPassate)) {
    foreach ($prenotazioniPassate as $prenotazione) {
        $ordini = OrdineDAO::getOrdineByPrenotazione($_SESSION['username'], $prenotazione["DataPrenotazione"]);
        if (!empty($ordini)) {
            $content .= '<section class="containerPlatesViewer"> <h3>     Questi sono i piatti che hai ordinato in data ' . $prenotazione["DataPrenotazione"] . '</h3>';
            $content .= "<ul class='flexable'>";
            foreach ($ordini as $piatto) {
                $refactorNomePiatto = str_replace(' ', '', strtolower($piatto['NomePiatto']));
                //$ariaLabel = 'Piatto: ' . $piatto['NomePiatto'] . ', Descrizione: ' . $piatto['Descrizione'];
                $templatePlatesOld = $templatePlatesQ;
                $templatePlatesOld = str_replace('{{NomePiattoUnderscored}}', $refactorNomePiatto, $templatePlatesOld);
                $templatePlatesOld = str_replace('{{NomePiatto}}', $piatto['NomePiatto'], $templatePlatesOld);
                $templatePlatesOld = str_replace('{{Descrizione}}', $piatto['Descrizione'], $templatePlatesOld);
                $templatePlatesOld = str_replace('{{Quantita}}', $piatto['Quantita'], $templatePlatesOld);
                $content .= $templatePlatesOld;
            }
            $content .= "</ul></section>";
        }

    }
}



$menu = get_menu_Login();
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito
ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>