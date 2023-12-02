<?php

require_once "Utility/utilities.php";
require_once 'DAO/PiattoDAO.php';

$templatePath = 'Layouts/main.html';
$pricesTPath = 'Layouts/pricesForMenu.html';
$plateslayoutPath = 'Layouts/MenuItemWithPrice.html';
if (!file_exists($templatePath)) {
    die("Template file not found: $templatePath");
}

$template = file_get_contents($templatePath);
if ($template === false) {
    die("Failed to load template file: $templatePath");
}

$pageID = 'menuCenaBody';
$title = "Menu Cena - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  Menu Pranzo</p> ';

$prices = file_get_contents($pricesTPath);
if ($prices === false) {
    die("Failed to load template file: $pricesTPath");
}
$prices = str_replace('{{TipoMenu}}', 'Pranzo', $prices);
$prices = str_replace('{{PrezzoLunVen}}', '14.10', $prices);
$prices = str_replace('{{PrezzoFestivo}}', '16.10', $prices);

if (file_get_contents($plateslayoutPath) === false) {
    die("Failed to load template file: $plateslayoutPath");
}

$content = '';
$content .= $prices;
$content .= '<section id="PiattiMenu" class="containerPlatesViewer"><h2>Plates</h2>';

$content .= '<ul class="flexable">';
$piattoDAO = new PiattoDAO();
$piatti = PiattoDAO::getPiattoByTipoMenu('Pranzo');
if (!empty($piatti)) {
    foreach ($piatti as $piatto) {
        $piattotemplates = file_get_contents($plateslayoutPath);
        $piattotemplates = str_replace('{{NomeUnderscored}}', str_replace(' ', '_', strtolower($piatto['NomePiatto'])), $piattotemplates);
        $piattotemplates = str_replace('{{Nome}}', $piatto['NomePiatto'], $piattotemplates);
        $piattotemplates = str_replace('{{Descrizione}}', $piatto['Descrizione'], $piattotemplates);
        $piattotemplates = str_replace('{{Prezzo}}', $piatto['Prezzo'], $piattotemplates);
        $content .= $piattotemplates;
    }
} else {
    $content .= "No piatti found.";
}

$content .= '</ul> </section>';


$menu = get_menu_NoLogin();
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>