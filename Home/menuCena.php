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
$breadcrumbs = '<p>Ti trovi in:  Menu Cena</p> ';

$prices = file_get_contents($pricesTPath);
if ($prices === false) {
    die("Failed to load template file: $pricesTPath");
}
$prices = str_replace('{{TipoMenu}}', 'cena', $prices);
$prices = str_replace('{{PrezzoLunVen}}', '20.10', $prices);
$prices = str_replace('{{PrezzoFestivo}}', '23.10', $prices);

if (file_get_contents($plateslayoutPath) === false) {
    die("Failed to load template file: $plateslayoutPath");
}

$content = '';
$content .= $prices;
$content .= '<section id="PiattiMenu" class="containerPlatesViewer"><h2>Plates</h2>';

$content .= '<ul>';
$piattoDAO = new PiattoDAO();
$piatti = PiattoDAO::getAllPiatti();
if (!empty($piatti)) {
    $piattotemplate = file_get_contents($plateslayoutPath);
    foreach ($piatti as $piatto) {
        $piattotemplates = $piattotemplate;
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