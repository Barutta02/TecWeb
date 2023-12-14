<?php


define("ROOT_FOLDER", "/TecWeb/Home/");


/*
    Rimpiazza i placeholder del template html del sito
*/
function replace_in_page($html, $title, $id, $breadcrumbs, $keywords, $description, $content, $onload)
{
    //Header presente in ogni pagina
    $header = file_get_contents('Layouts/header.html');

    $footer = file_get_contents('Layouts/footer.html');

    $html = str_replace('{{onload}}', $onload, $html);

    $html = str_replace('{{header}}', $header, $html);

    $html = str_replace('{{title}}', $title, $html);
    $html = str_replace('{{keywords}}', $keywords, $html);
    $html = str_replace('{{description}}', $description, $html);
    $html = str_replace('{{pageID}}', $id, $html);
    $html = str_replace('{{breadcrumbs}}', $breadcrumbs, $html);
    $html = str_replace('{{content}}', $content, $html);

    //Footer presente in ogni pagina
    $html = str_replace('{{footer}}', $footer, $html);

    return $html;
}

function get_prices_section($tipoMenu, $prezzoLunVen, $PrezzoFestivi)
{
    $pricesTPath = 'Layouts/pricesForMenu.html';
    $prices = file_get_contents($pricesTPath);
    if ($prices === false) {
        die("Failed to load template file: $pricesTPath");
    }
    $prices = str_replace('{{TipoMenu}}', $tipoMenu, $prices);
    $prices = str_replace('{{PrezzoLunVen}}', $prezzoLunVen, $prices);
    $prices = str_replace('{{PrezzoFestivo}}', $PrezzoFestivi, $prices);
    return $prices;
}

function get_all_formatted_plates_Menu($piatti)
{
    $htmlContent = '';
    $plateslayoutPath = 'Layouts/MenuItemWithPrice.html';
    if (file_get_contents($plateslayoutPath) === false) {
        die("Failed to load template file: $plateslayoutPath");
    }
    if (!empty($piatti)) {
        $htmlContent .= '<ul class="flexable">';
        $piattotemplate = file_get_contents($plateslayoutPath);
        foreach ($piatti as $piatto) {
            $piattotemplates = $piattotemplate;
            $piattotemplates = str_replace('{{NomeUnderscored}}', str_replace(' ', '', strtolower($piatto['NomePiatto'])), $piattotemplates);
            $piattotemplates = str_replace('{{Nome}}', $piatto['NomePiatto'], $piattotemplates);
            $piattotemplates = str_replace('{{Descrizione}}', $piatto['Descrizione'], $piattotemplates);
            $piattotemplates = str_replace('{{Prezzo}}', $piatto['Prezzo'], $piattotemplates);
            $htmlContent .= $piattotemplates;
        }
        $htmlContent .= '</ul>';
    } else {
        $htmlContent .= "No piatti found.";
    }
    return $htmlContent;
}

/*
    RITORNA LA FORM PER LA NON VISUALIZZAZIONE DEGLI ALLERGENI
*/
function get_allergeni_form_section()
{
    require_once 'DAO/AllergeneDAO.php';
    $templatePathAllergeniChBox = 'Layouts/checkboxItemAllergene.html';
    $templateAllergeniChbox = file_get_contents($templatePathAllergeniChBox);
    if ($templateAllergeniChbox === false) {
        die("Failed to load template file: $templatePathAllergeniChBox");
    }
    $content = '<section id="allergeni">
<h4 >Seleziona gli allergeni da evitare:</h4>
<form>
<fieldset>
  <ul id="listaAllergeni">';

    $allergeni = AllergeneDAO::getAllAllergeni();

    if (!empty($allergeni)) {
        foreach ($allergeni as $allergene) {
            $templateAllergeniChboxN = $templateAllergeniChbox;
            $templateAllergeniChboxN = str_replace('{{NomeAllergene}}', $allergene["NomeAllergene"], $templateAllergeniChbox);
            $content .= $templateAllergeniChboxN;
        }
    }
    $content .= '</ul></fieldset>
</form>
</section>';
    return $content;
}


/**PRENDI IL FORM PER LA PRENOTAZIONE DEI PIATTI DIVISI IN FIELDSET PER CATEGORIA */
function get_prenotation_form_menu($process_php_action)
{
    require_once 'DAO/PiattoDAO.php';
    require_once 'DAO/CategoriaDAO.php';
    $platesQuanityInputlayoutPath = 'Layouts/MenuItemInputQuantity.html';
    $templatePlatesInput = file_get_contents($platesQuanityInputlayoutPath);
    if ($templatePlatesInput === false) {
        die("Failed to load template file: $platesQuanityInputlayoutPath");
    }
    $content = ' <form action="' . $process_php_action . '" method="post">';
    $categorie = CategoriaDAO::getAllCategory();
    if (!empty($categorie)) {
        foreach ($categorie as $categoria) {
            $piatti = PiattoDAO::getPlatesByHours_Category($categoria['Nome']);
            if (!empty($piatti)) {
                $content .= " <fieldset> <legend>" . $categoria['Nome'] . "</legend> <ul class='flexable'>";
                foreach ($piatti as $piatto) {
                    $templateSliderInputIter = $templatePlatesInput;
                    $allergeniPiatto = AllergeneDAO::getAllergeniByPiatto(intval($piatto['IDPiatto']));
                    $refactorNomePiatto = str_replace(' ', '', strtolower($piatto['NomePiatto']));
                    // $ariaLabel = 'Piatto: ' . $piatto['NomePiatto'] . ', Descrizione: ' . $piatto['Descrizione'];
                    $templateSliderInputIter = str_replace('{{ListaAllergeni}}', implode(" ", $allergeniPiatto), $templateSliderInputIter);
                    $templateSliderInputIter = str_replace('{{NomePiattoUnderscored}}', $refactorNomePiatto, $templateSliderInputIter);
                    $templateSliderInputIter = str_replace('{{NomePiatto}}', $piatto['NomePiatto'], $templateSliderInputIter);
                    $templateSliderInputIter = str_replace('{{Descrizione}}', $piatto['Descrizione'], $templateSliderInputIter);
                    $templateSliderInputIter = str_replace('{{IDPiatto}}', $piatto['IDPiatto'], $templateSliderInputIter);
                    $platesAllergeniList = "";
                    foreach ($allergeniPiatto as $allergene) {
                        $platesAllergeniList .= '<dd aria-label="Allergene ' . $allergene . '" title="' . $allergene . '" class="allergeneImage ' . $allergene . 'Image" data-allergene="' . $allergene . '"></dd>';
                    }
                    $templateSliderInputIter = str_replace('{{Allergeni}}', $platesAllergeniList, $templateSliderInputIter);

                    $content .= $templateSliderInputIter;
                }
                $content .= "</ul></fieldset>";
            } else {
                $content .= "";
            }

        }
    } else {
        $content .= "No Categories found.";
    }

    $content .= '
<input type="submit" id="submitPrenotazione" value="Invia ordine">
</form>';
    return $content;
}

function get_table_avaible()
{
    require_once 'DAO/TavoloDAO.php';
    $tableSliderLayoutPath = 'Layouts/DisponibilitaTavoli.html';
    $tableSliderLayout = file_get_contents($tableSliderLayoutPath);
    if ($tableSliderLayout === false) {
        die("Failed to load template file: $tableSliderLayoutPath");
    }
    $tavoli = TavoloDAO::getAvaibleTable();
    $content = '';
    if (!empty($tavoli)) {
        $content .= " <ul class='tableList'>";

        foreach ($tavoli as $tavolo) {

            $templateSliderInputIter = $tableSliderLayout;
            // $ariaLabel = 'Piatto: ' . $piatto['NomePiatto'] . ', Descrizione: ' . $piatto['Descrizione'];
            $templateSliderInputIter = str_replace('{{Totale_tavoli}}', $tavolo['totale_disp'], $templateSliderInputIter);
            $templateSliderInputIter = str_replace('{{Occupati}}', $tavolo['numeroOccupati'], $templateSliderInputIter);
            $templateSliderInputIter = str_replace('{{NumPosti}}', $tavolo['numPosti'], $templateSliderInputIter);

            $content .= $templateSliderInputIter;
        }
        $content .= "</ul>";
    } else {
        $content .= "No table found.";
    }
    return $content;
}
function get_active_prenotation()
{
    require_once 'DAO/PrenotazioneDAO.php';
    $tableSliderLayoutPath = 'Layouts/activePrenotation.html';
    $tableSliderLayout = file_get_contents($tableSliderLayoutPath);
    if ($tableSliderLayout === false) {
        die("Failed to load template file: $tableSliderLayoutPath");
    }
    $tavoli = PrenotazioneDAO::getActivePrenotation();
    $content = '';
    if (!empty($tavoli)) {
        $content .= " <ul class='ActivePrenotationList'>";

        foreach ($tavoli as $tavolo) {

            $templateSliderInputIter = $tableSliderLayout;
            // $ariaLabel = 'Piatto: ' . $piatto['NomePiatto'] . ', Descrizione: ' . $piatto['Descrizione'];
            $templateSliderInputIter = str_replace('{{numTavolo}}', $tavolo['Tavolo'], $templateSliderInputIter);
            $templateSliderInputIter = str_replace('{{Orario}}', $tavolo['DataPrenotazione'], $templateSliderInputIter);
            $templateSliderInputIter = str_replace('{{Username}}', $tavolo['Username'], $templateSliderInputIter);

            $content .= $templateSliderInputIter;
        }
        $content .= "</ul>";
    } else {
        $content .= "No active prenotation found.";
    }
    return $content;
}

/*
    Rimpiazza i placeholder del template html dell'area utente
    Senza keywords e descrizione
*/
function replace_in_user_page(string $html, string $title, string $id, string $breadcrumbs, string $content, string $onload)
{

    //Header presente in ogni pagina
    $header = file_get_contents('../layouts/header.html');
    $html = str_replace('{{onload}}', $onload, $html);
    $html = str_replace('{{header}}', $header, $html);
    $html = str_replace('{{title}}', $title, $html);
    $html = str_replace('{{pageID}}', $id, $html);
    $html = str_replace('{{breadcrumbs}}', $breadcrumbs, $html);
    $html = str_replace('{{content}}', $content, $html);

    //Footer presente in ogni pagina
    $footer = file_get_contents('../layouts/footer.html');
    $footer = str_replace("privacy.html", "../privacy.html", $footer);
    $html = str_replace('{{footer}}', $footer, $html);

    return $html;
}

/*
    Rimpiazza i codici per la lingua con tag span
    [en]...[/en]
*/
function parse_lang(string $string, bool $delete)
{

    if ($delete) {
        $replaceStart = '';
        $replaceEnd = '';
    } else {
        $replaceStart = '<span lang="${2}">';
        $replaceEnd = '</span>';
    }

    //Rimpiazza i tag di fine con </span>
    $string = preg_replace('/\[\/.{2}\]/', $replaceEnd, $string);

    //Rimpiazza i tag di inizio con <span lang="xx">
    $string = preg_replace('/(\[)([a-z]{2})(\])/', $replaceStart, $string);

    return $string;

}

/*
    Rimpiazza i codici per l'abbreviazione con tag span
    _cm|centrimetri_
*/
function parse_abbr(string $string, bool $delete)
{

    if ($delete) {
        $replace = '';
    } else {
        $replace = '<abbr title="${2}">${1}</abbr>';
    }

    return preg_replace('/_(.*?)\|(.*?)_/', $replace, $string);
}


/* 
    Rimpiazza {{menu}} con il menú in base alla pagina in cui si trova l'utente
*/
function get_menu_NoLogin()
{

    $menu = '';

    // Link da inserire
    $links = ["index.php", "menuPranzo.php", "menuCena.php", "chiSiamo.php", "contattaci.php"];
    // Nomi delle voci di menu
    $names = ["Home", "Menu pranzo", "Menu cena", "Chi Siamo", "Contatti"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["en", "", "", "", ""];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting 
    $strToRemove = ROOT_FOLDER;
    $currentPage = str_replace($strToRemove, "", $_SERVER['REQUEST_URI']);

    for ($i = 0; $i < $nLinks; $i++) {
        if ($currentPage == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li id="currentLink" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</li>';
        } else {
            $menu .= '<li><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</a></li>';
        }
    }
    $menu .= '<li><a class="button userAreaLink" href="login.php" >Area Utente</a></li>';
    return $menu;
}

function get_menu_Login()
{

    $menu = '';

    // Link da inserire
    $links = ["Prenota.php", "VisualizzaOrdini.php", "NuovaPrenotazione.php", "index.php"];
    // Nomi delle voci di menu
    $names = ["Prenota", "Visualizza ordini", "Gestisci prenotazione", "Torna in Home"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["", "", "", "it-en"];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting 
    $strToRemove = ROOT_FOLDER;
    $currentPage = str_replace($strToRemove, "", $_SERVER['REQUEST_URI']);

    for ($i = 0; $i < $nLinks; $i++) {
        if ($currentPage == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li id="currentLink" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</li>';
        } else {
            $menu .= '<li><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</a></li>';
        }
    }
    return $menu;
}

function get_menu_Admin()
{

    $menu = '';

    // Link da inserire
    $links = ["AdminPanel.php", "freeTable.php", "index.php"];
    // Nomi delle voci di menu
    $names = ["Pannello amministratore", "Gestione Prenotazioni", "Torna in home"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["", "", "it-en"];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting 
    $strToRemove = ROOT_FOLDER;
    $currentPage = str_replace($strToRemove, "", $_SERVER['REQUEST_URI']);

    for ($i = 0; $i < $nLinks; $i++) {
        if ($currentPage == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li id="currentLink" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</li>';
        } else {
            $menu .= '<li><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</a></li>';
        }
    }
    return $menu;
}



?>