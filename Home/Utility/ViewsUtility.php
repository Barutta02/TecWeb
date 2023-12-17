<?php
/**
 * FILE PER FUNZIONI DI UTILITA DEDICATE ALLA TRASFORMAZIONE DI VISTE HTML 
 */
function get_prices_section($tipoMenu, $prezzoLunVen, $PrezzoFestivi)
{
    $prices = getTemplate('Layouts/pricesForMenu.html');
    $prices = str_replace('{{TipoMenu}}', $tipoMenu, $prices);
    $prices = str_replace('{{PrezzoLunVen}}', $prezzoLunVen, $prices);
    $prices = str_replace('{{PrezzoFestivo}}', $PrezzoFestivi, $prices);
    return $prices;
}

/**
 * Metodo universale che dato un template per visionare piatti sostituisce il contenuto con i dati passati
 */
function formatPlateString($piattotemplates, $nomePiatto = "", $Descrizione = "", $Prezzo = "", $Quantita = "", $IDPiatto = "", $allergeniPiatto = [])
{
    $piattotemplates = str_replace('{{NomePiattoUnderscored}}', str_replace(' ', '', strtolower($nomePiatto)), $piattotemplates);
    $piattotemplates = str_replace('{{NomePiatto}}', $nomePiatto, $piattotemplates);
    $piattotemplates = str_replace('{{Descrizione}}', $Descrizione, $piattotemplates);
    $piattotemplates = str_replace('{{Prezzo}}', $Prezzo, $piattotemplates);
    $piattotemplates = str_replace('{{Quantita}}', $Quantita, $piattotemplates);
    $piattotemplates = str_replace('{{IDPiatto}}', $IDPiatto, $piattotemplates);
    $piattotemplates = str_replace('{{ListaAllergeni}}', implode(" ", $allergeniPiatto), $piattotemplates);
    $platesAllergeniList = "";
    foreach ($allergeniPiatto as $allergene) {
        $platesAllergeniList .= '<dd aria-label="Allergene ' . $allergene . '" title="' . $allergene . '" class="allergeneImage ' . $allergene . 'Image" data-allergene="' . $allergene . '"></dd>';
    }
    $piattotemplates = str_replace('{{Allergeni}}', $platesAllergeniList, $piattotemplates);
    return $piattotemplates;
}

/**Metodo utilizzato per menu pranzo e cena in no loggin */
function get_all_formatted_plates_Menu($piatti)
{
    $htmlContent = '';

    if (!empty($piatti)) {
        $htmlContent .= '<ul class="flexable">';
        $piattotemplate = getTemplate('Layouts/MenuItemWithPrice.html');
        foreach ($piatti as $piatto) {
            $htmlContent .= formatPlateString($piattotemplate, $piatto['NomePiatto'], $piatto['Descrizione'], $piatto['Prezzo']);
        }
        $htmlContent .= '</ul>';
    } else {
        $htmlContent .= "No piatti found.";
    }
    return $htmlContent;
}

/*
    RITORNA LA FORM PER LA NON VISUALIZZAZIONE DEGLI ALLERGENI
 * Metodo utilizzato per prenota.php
 */
function get_allergeni_form_section()
{
    require_once 'DAO/AllergeneDAO.php';
    //Sezione lista allergeni
    $templateListaAllergeni = getTemplate('Layouts/SezioneListaAllergeni.html');
    //Checkboc allergeni
    $templatePathAllergeniChBox = 'Layouts/checkboxItemAllergene.html';
    $templateAllergeniChbox = file_get_contents($templatePathAllergeniChBox);
    if ($templateAllergeniChbox === false) {
        die("Failed to load template file: $templatePathAllergeniChBox");
    }

    $content = '';

    $allergeni = AllergeneDAO::getAllAllergeni();

    if (!empty($allergeni)) {
        foreach ($allergeni as $allergene) {
            $templateAllergeniChboxN = $templateAllergeniChbox;
            $templateAllergeniChboxN = str_replace('{{NomeAllergene}}', $allergene["NomeAllergene"], $templateAllergeniChbox);
            $content .= $templateAllergeniChboxN;
        }
    }
    $content = str_replace('{{ListaAllergeni}}', $content, $templateListaAllergeni);
    return $content;
}

/**PRENDI IL FORM PER LA PRENOTAZIONE DEI PIATTI DIVISI IN FIELDSET PER CATEGORIA */
function get_prenotation_form_menu($process_php_action)
{
    require_once 'DAO/PiattoDAO.php';
    require_once 'DAO/CategoriaDAO.php';
    $templatePlatesInput = getTemplate('Layouts/MenuItemInputQuantity.html');
    $content = ' <form action="' . $process_php_action . '" method="post">';
    $categorie = CategoriaDAO::getAllCategory();
    if (!empty($categorie)) {
        foreach ($categorie as $categoria) {
            $piatti = PiattoDAO::getPlatesByHours_Category($categoria['Nome']);
            if (!empty($piatti)) {
                $content .= " <fieldset> <legend>" . $categoria['Nome'] . "</legend> <ul class='flexable'>";
                foreach ($piatti as $piatto) {
                    $allergeniPiatto = AllergeneDAO::getAllergeniByPiatto(intval($piatto['IDPiatto']));
                    $content .= formatPlateString($templatePlatesInput, $piatto['NomePiatto'], $piatto['Descrizione'], "", "", $piatto['IDPiatto'], $allergeniPiatto);
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

/**
 * Visualizza ordini old orders list divise per diverse prenotazioni
 */
function getThisPrenotationOrderView()
{
    $templatePlatesQC = getTemplate('Layouts/MenuItemViewQuantityConsegnato.html');
    $content = '<section id="ordiniOdierni" class="containerPlatesViewer">
    <h2 >' . $_SESSION['name'] . ' questi sono i piatti che hai ordinato oggi
    </h2> <ul class="flexable">';
    $piatti = OrdineDAO::getOrdineByPrenotazione($_SESSION['username'], $_SESSION['data_prenotazione_inCorso']);
    if (!empty($piatti)) {

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

    } else {
        $content .= "Devi ancora effettuare ordinazioni oggi " . $_SESSION['name'] . '.';
    }
    $content .= "</ul></section>";
    return $content;
}
/**
 * Visualizza ordini old orders list divise per diverse prenotazioni
 */
function getOldOrderView()
{
    $templatePlatesQ = getTemplate('Layouts/MenuItemViewQuantity.html');
    $content = '';
    $prenotazioniPassate = PrenotazioneDAO::getOldPrenotazioniByUsername($_SESSION['username'], $_SESSION['data_prenotazione_inCorso']);
    if (!empty($prenotazioniPassate)) {

        foreach ($prenotazioniPassate as $prenotazione) {
            $ordini = OrdineDAO::getOrdineByPrenotazione($_SESSION['username'], $prenotazione["DataPrenotazione"]);
            if (!empty($ordini)) {
                $content .= '<section class="containerPlatesViewer"> <h3>     Questi sono i piatti che hai ordinato in data ' . $prenotazione["DataPrenotazione"] . '</h3>';
                $content .= "<ul class='flexable'>";
                foreach ($ordini as $piatto) {
                    $content .= formatPlateString($templatePlatesQ, $piatto['NomePiatto'], $piatto['Descrizione'], "", $piatto['Quantita']);
                }
                $content .= "</ul></section>";
            }

        }
    }
    return $content;
}

/**
 * Pannello amministratore vista sugli ordini da fare
 */
function toDoOrdersView()
{
    //TEMPLATE ORDINAZIONI DA FARE
    $templatePlatesAdmin = getTemplate('Layouts/adminOrderManager.html');
    $piatti = OrdineDAO::getAllToDoOrder();
    $content = '';
    if (!empty($piatti)) {
        $content .= "<ul class='flexable'>";
        foreach ($piatti as $piatto) {
            $refactorNomePiatto = str_replace(' ', '', strtolower($piatto['NomePiatto']));
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
    return $content;
}

function get_table_avaible()
{
    require_once 'DAO/TavoloDAO.php';
    $tableSliderLayout = getTemplate('Layouts/DisponibilitaTavoli.html');
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
    $tableSliderLayout = getTemplate('Layouts/activePrenotation.html');

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
?>