<?php
require_once "Utility/utilities.php";
require_once 'DAO/PiattoDAO.php';
require_once 'DAO/AllergeneDAO.php';
require_once 'DAO/CategoriaDAO.php';
//Control login e di aver gia scelto numero di persone e tavolo
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: Registration/login.php");
}
if (!isset($_SESSION["data_prenotazione_inCorso"])) {
    header("Location: NuovaPrenotazione.php");
}

$templatePathAllergeniChBox = 'Layouts/checkboxItemAllergene.html';
$platesQuanityInputlayoutPath = 'Layouts/MenuItemInputQuantity.html';
$templatePath = 'Layouts/main.html';

if (!file_exists($templatePath)) {
    die("Template file not found: $templatePath");
}
$template = file_get_contents($templatePath);

$templateAllergeniChbox = file_get_contents($templatePathAllergeniChBox);
if ($templateAllergeniChbox === false) {
    die("Failed to load template file: $templatePathAllergeniChBox");
}

$templatePlatesInput = file_get_contents($platesQuanityInputlayoutPath);
if ($templatePlatesInput === false) {
    die("Failed to load template file: $platesQuanityInputlayoutPath");
}

$pageID = 'PrenotaBody';
$title = "Prenota piatti - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  Prenota</p> ';


$content = '<section id="allergeni">
<h4 tabindex="6">Seleziona gli allergeni da evitare:</h4>
<form>
  <ul id="listaAllergeni">';

$allergeneDAO = new AllergeneDAO();
$allergeni = AllergeneDAO::getAllAllergeni();
$tabIndex_offset = 6;

if (!empty($allergeni)) {
    foreach ($allergeni as $allergene) {
        $templateAllergeniChboxN = $templateAllergeniChbox;
        $templateAllergeniChboxN = str_replace('{{NomeAllergene}}', $allergene["NomeAllergene"], $templateAllergeniChbox);
        $content .= $templateAllergeniChboxN;
    }
}
$content .= '</ul>
</form>
</section>';

$content .= ' <section id="PiattiMenu" class="containerPlatesViewer">
<h2 tabindex="20"> ' . $_SESSION['name'] . ' ordina qui i tuoi piatti
</h2>
<form action="process/process_prenotazione.php" method="post">';


$piattoDAO = new PiattoDAO();
$categoriaDAO = new CategoriaDAO();
$tabIndex_offset = 20;

$categorie = CategoriaDAO::getAllCategory();
if (!empty($categorie)) {
    foreach ($categorie as $categoria) {
        $piatti = PiattoDAO::getPiattoByTipoCategory($categoria['Nome']);
        if (!empty($piatti)) {
            $content .= " <fieldset> <legend>" . $categoria['Nome'] . "</legend> <ul>";
            foreach ($piatti as $piatto) {
                $templatePlatesInputIter = $templatePlatesInput;
                $allergeniPiatto = AllergeneDAO::getAllergeniByPiatto(intval($piatto['IDPiatto']));
                $refactorNomePiatto = str_replace(' ', '_', strtolower($piatto['NomePiatto']));
                // $ariaLabel = 'Piatto: ' . $piatto['NomePiatto'] . ', Descrizione: ' . $piatto['Descrizione'];
                $templatePlatesInputIter = str_replace('{{ListaAllergeni}}', implode(" ", $allergeniPiatto), $templatePlatesInputIter);
                $templatePlatesInputIter = str_replace('{{NomePiattoUnderscored}}', $refactorNomePiatto, $templatePlatesInputIter);
                $templatePlatesInputIter = str_replace('{{NomePiatto}}', $piatto['NomePiatto'], $templatePlatesInputIter);
                $templatePlatesInputIter = str_replace('{{Descrizione}}', $piatto['Descrizione'], $templatePlatesInputIter);
                $templatePlatesInputIter = str_replace('{{IDPiatto}}', $piatto['IDPiatto'], $templatePlatesInputIter);

                $content .= $templatePlatesInputIter;
            }
            $content .= "</ul></fieldset>";
        } else {
            $content .= "No piatti found.";
        }

    }
} else {
    $content .= "No Categories found.";
}

$content .= '
<input type="submit" id="submitPrenotazione" value="Invia ordine">
</form>
</section>';


$menu = get_menu_Login();
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>