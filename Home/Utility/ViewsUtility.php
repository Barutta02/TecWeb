<?php
/**
 * FILE PER FUNZIONI DI UTILITA DEDICATE ALLA TRASFORMAZIONE DI VISTE HTML 
 */
function get_prices_section($tipoMenu, $prezzoLunVen, $PrezzoFestivi)
{
    try {
        $prices = getTemplate('Layouts/pricesForMenu.html');
        $prices = str_replace('{{TipoMenu}}', $tipoMenu, $prices);
        $prices = str_replace('{{PrezzoLunVen}}', $prezzoLunVen, $prices);
        $prices = str_replace('{{PrezzoFestivo}}', $PrezzoFestivi, $prices);
        return $prices;
    } catch (Throwable $error) {
        return get_error_msg();
    }
}

# Aggiunge alla stringa la corretta formattazione per le lingue
function add_translation_span($text)
{
    $word_span_replace = array(
        # Japan
        'Nigiri' => '<span lang="ja">Nigiri</span>',
        'Tartare' => '<span lang="ja">Tartare</span>',
        'Sashimi' => '<span lang="ja">Sashimi</span>',
        'Uramaki' => '<span lang="ja">Uramaki</span>',
        'Tatkai' => '<span lang="ja">Tatkai</span>',
        'Maki' => '<span lang="ja">Maki</span>',
        'Gyoza' => '<span lang="ja">Gyoza</span>',
        'Tempura' => '<span lang="ja">Tempura</span>',
        'Sushi' => '<span lang="ja">Sushi</span>',
        # English
        'Deluxe' => '<span lang="en">Deluxe</span>',
        'Roll' => '<span lang="en">Roll</span>',
        'Rainbow' => '<span lang="en">Rainbow</span>',
        'Dragon' => '<span lang="en">Dragon</span>',
        'Premium' => '<span lang="en">Premium</span>',
        'Philly' => '<span lang="en">Philly</span>'
    );

    foreach ($word_span_replace as $word => $tag) {
        $text = str_replace($word, $tag, $text);
    }

    return $text;
}

/**
 * Metodo universale che dato un template per visionare piatti sostituisce il contenuto con i dati passati
 */
function formatPlateString($piattotemplates, $nomePiatto = "", $Descrizione = "", $Prezzo = "", $Quantita = "", $IDPiatto = "", $allergeniPiatto = [], $Ntavolo = "", $Cliente = "", $Orario = "", $isConsegnato = "", $frequenza = "")
{
    $piattotemplates = str_replace('{{NomePiattoUnderscored}}', str_replace(' ', '', strtolower($nomePiatto)), $piattotemplates);
    $piattotemplates = str_replace('{{NomePiatto}}', add_translation_span($nomePiatto), $piattotemplates);
    $piattotemplates = str_replace('{{Descrizione}}', $Descrizione, $piattotemplates);
    $piattotemplates = str_replace('{{Prezzo}}', $Prezzo, $piattotemplates);
    $piattotemplates = str_replace('{{Quantita}}', $Quantita, $piattotemplates);
    $piattotemplates = str_replace('{{IDPiatto}}', $IDPiatto, $piattotemplates);
    $piattotemplates = str_replace('{{ListaAllergeni}}', implode(" ", $allergeniPiatto), $piattotemplates);
    $piattotemplates = str_replace('{{NTavolo}}', $Ntavolo, $piattotemplates);
    $piattotemplates = str_replace('{{Cliente}}', $Cliente, $piattotemplates);
    $piattotemplates = str_replace('{{Orario}}', $Orario, $piattotemplates);
    $piattotemplates = str_replace('{{isConsegnato}}', (($isConsegnato == true) ? "Si" : "No"), $piattotemplates);
    $piattotemplates = str_replace('{{Frequenza}}', $frequenza, $piattotemplates);
    $platesAllergeniList = "";
    foreach ($allergeniPiatto as $allergene) {
        $platesAllergeniList .= '<dd aria-label="Allergene ' . $allergene . '" title="' . $allergene . '" class="allergeneImage ' . $allergene . 'Image" data-allergene="' . $allergene . '"></dd>';
    }
    $piattotemplates = str_replace('{{Allergeni}}', $platesAllergeniList, $piattotemplates);
    return $piattotemplates;
}

/**Metodo utilizzato per menu pranzo e cena in no loggin */
function get_all_formatted_plates_Menu($categoria)
{
    try {
        $htmlContent = '';

        $piatti = PiattoDAO::getPiattoByTipoMenu($categoria);

        if (!empty($piatti)) {
            $htmlContent .= '<ul class="flexable">';
            $piattotemplate = getTemplate('Layouts/MenuItemWithPrice.html');
            foreach ($piatti as $piatto) {
                $htmlContent .= formatPlateString($piattotemplate, $piatto['nome'], $piatto['descrizione'], $piatto['prezzo']);
            }
            $htmlContent .= '</ul>';
        } else {
            $htmlContent .= "<p>No piatti found.</p>";
        }
        return $htmlContent;
    } catch (Throwable $th) {
        return get_error_msg();
    }
}

/*
    RITORNA LA FORM PER LA NON VISUALIZZAZIONE DEGLI ALLERGENI
 * Metodo utilizzato per prenota.php
 */
function get_allergeni_form_section()
{
    try {
        require_once 'DAO/AllergeneDAO.php';
        //Sezione lista allergeni
        $templateListaAllergeni = getTemplate('Layouts/SezioneListaAllergeni.html');
        //Checkboc allergeni
        $templateAllergeniChbox = getTemplate('Layouts/checkboxItemAllergene.html');
        $content = '';
        $allergeni = AllergeneDAO::getAllAllergeni();
        if (!empty($allergeni)) {
            foreach ($allergeni as $allergene) {
                $templateAllergeniChboxN = $templateAllergeniChbox;
                $templateAllergeniChboxN = str_replace('{{NomeAllergene}}', $allergene["nome"], $templateAllergeniChbox);
                $content .= $templateAllergeniChboxN;
            }
        }
        $content = str_replace('{{ListaAllergeni}}', $content, $templateListaAllergeni);
        return $content;
    } catch (Throwable $error) {
        return get_error_msg();
    }
}

/**PRENDI IL FORM PER LA PRENOTAZIONE DEI PIATTI DIVISI IN FIELDSET PER CATEGORIA */
function get_prenotation_form_menu($process_php_action)
{
    try {
        require_once 'DAO/PiattoDAO.php';
        require_once 'DAO/CategoriaDAO.php';
        $templatePlatesInput = getTemplate('Layouts/MenuItemInputQuantity.html');
        $content = ' <form action="' . $process_php_action . '" method="post">';
        $categorie = CategoriaDAO::getAllCategory();
        if (!empty($categorie)) {
            foreach ($categorie as $categoria) {
                $piatti = PiattoDAO::getPlatesByHours_Category($categoria['categoria']);
                if (!empty($piatti)) {
                    $content .= " <fieldset> <legend>" . $categoria['categoria'] . "</legend> <ul class='flexable'>";
                    foreach ($piatti as $piatto) {
                        $allergeniPiatto = AllergeneDAO::getAllergeniByPiatto(intval($piatto['id']));
                        $content .= formatPlateString($templatePlatesInput, $piatto['nome'], $piatto['descrizione'], "", "", $piatto['id'], $allergeniPiatto);
                    }
                    $content .= "</ul></fieldset>";
                } else {
                    $content .= "";
                }

            }
        } else {
            $content .= "<p>No Categories found.</p>";
        }

        $content .= '
    <input type="submit" id="submitPrenotazione" value="Invia ordine">
    </form>';
        return $content;
    } catch (Throwable $error) {
        return get_error_msg();
    }
}

/**
 * Visualizza ordini old orders list divise per diverse prenotazioni
 */
function getThisPrenotationOrderView()
{
    try {
        $templatePlatesQC = getTemplate('Layouts/MenuItemViewQuantityConsegnato.html');
        $content = '<section id="ordiniOdierni" class="containerPlatesViewer">
        <h2 >' . $_SESSION['name'] . ' questi sono i piatti che hai ordinato oggi
        </h2> <ul class="flexable">';
        $piatti = OrdineDAO::getOrdineByPrenotazione($_SESSION['username'], $_SESSION['data_prenotazione_inCorso']);
        if (!empty($piatti)) {

            foreach ($piatti as $piatto) {
                $content .= formatPlateString($templatePlatesQC, $piatto['nome'], $piatto['descrizione'], "", $piatto['quantita'], "", [], "", "", "", $piatto['consegnato']);
            }

        } else {
            $content .= "<p>Devi ancora effettuare ordinazioni oggi " . $_SESSION['name'] . '.</p>';
        }
        $content .= "</ul></section>";
        return $content;
    } catch (Throwable $error) {
        return get_error_msg();
    }
}
/**
 * Visualizza ordini old orders list divise per diverse prenotazioni
 */
function getOldOrderView()
{
    try {
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
                        $content .= formatPlateString($templatePlatesQ, $piatto['nome'], $piatto['descrizione'], "", $piatto['quantita']);
                    }
                    $content .= "</ul></section>";
                }
            }
        }
        return $content;
    } catch (Throwable $error) {
        return get_error_msg();
    }
}

/**
 * Pannello amministratore vista sugli ordini da fare
 */
function toDoOrdersView()
{
    try {
        $templatePlatesAdmin = getTemplate('Layouts/adminOrderManager.html');
        $piatti = OrdineDAO::getAllToDoOrder();
        $content = '';
        if (!empty($piatti)) {
            $content .= "<ul class='flexable'>";
            foreach ($piatti as $piatto) {
                $content .= formatPlateString($templatePlatesAdmin, $piatto['nome'], $piatto['descrizione'], "", $piatto['quantita'], $piatto['id'], [], $piatto['tavolo'], $piatto['cliente'], $piatto['data_ora']);
            }
            $content .= "</ul>";
        } else {
            $content .= "<p>Devono ancora effettuare ordinazioni.</p>";
        }
        return $content;
    } catch (Throwable $error) {
        return get_error_msg();
    }
}

function get_table_avaible()
{
    try {
        require_once 'DAO/TavoloDAO.php';
        $tableSliderLayout = getTemplate('Layouts/DisponibilitaTavoli.html');
        $tavoli = TavoloDAO::getAvaibleTable();
        $content = '';
        if (!empty($tavoli)) {
            $content .= " <ul class='tableList'>";
            foreach ($tavoli as $tavolo) {
                $templateSliderInputIter = $tableSliderLayout;
                $templateSliderInputIter = str_replace('{{Totale_tavoli}}', $tavolo['totale_disp'], $templateSliderInputIter);
                $templateSliderInputIter = str_replace('{{Occupati}}', $tavolo['numeroOccupati'], $templateSliderInputIter);
                $templateSliderInputIter = str_replace('{{NumPosti}}', $tavolo['numPosti'], $templateSliderInputIter);

                $content .= $templateSliderInputIter;
            }
            $content .= "</ul>";
        } else {
            $content .= "<p>No table found.</p>";
        }
        return $content;
    } catch (Throwable $th) {
        return get_error_msg();
    }
}
function get_active_prenotation()
{
    try {
        require_once 'DAO/PrenotazioneDAO.php';
        $tableSliderLayout = getTemplate('Layouts/activePrenotation.html');
        $tavoli = PrenotazioneDAO::getActivePrenotation();
        $content = '';
        if (!empty($tavoli)) {
            $content .= " <ul class='ActivePrenotationList'>";
            foreach ($tavoli as $tavolo) {
                $templateSliderInputIter = $tableSliderLayout;
                $templateSliderInputIter = str_replace('{{numTavolo}}', $tavolo['tavolo'], $templateSliderInputIter);
                $templateSliderInputIter = str_replace('{{numClienti}}', $tavolo['numero_persone'], $templateSliderInputIter);
                $templateSliderInputIter = str_replace('{{Orario}}', $tavolo['data_ora'], $templateSliderInputIter);
                $templateSliderInputIter = str_replace('{{Username}}', $tavolo['utente'], $templateSliderInputIter);
                $templateSliderInputIter = str_replace('{{IndicazioniAggiuntive}}', empty($tavolo['indicazione_aggiuntive']) || ctype_space($tavolo['indicazione_aggiuntive']) ? 'Nessuna.' : $tavolo['indicazione_aggiuntive'], $templateSliderInputIter);
                $content .= $templateSliderInputIter;
            }
            $content .= "</ul>";
        } else {
            $content .= "<p>No active prenotation found.</p>";
        }
        return $content;
    } catch (Throwable $th) {
        return get_error_msg();
    }
}
/**
 * Visualizza ordini frequenti nelle diverse prenotazioni
 */
function getFrequentView()
{
    try {
        $templatePlatesQC = getTemplate('Layouts/MenuItemViewFrequency.html');
        $content = '<section id="ordiniFrequenti" class="containerPlatesViewer">
        <h2 >' . $_SESSION['name'] . ' questi sono i piatti che ordini più frequentemente
        </h2> <ul class="flexable">';
        $piatti = OrdineDAO::getOrdiniFrequenti($_SESSION['username']);
        if (!empty($piatti)) {
            foreach ($piatti as $piatto) {
                $content .= formatPlateString($templatePlatesQC, $piatto['nome'], $piatto['descrizione'], "", "", "", [], "", "", "", "", $piatto['frequenza']);
            }
        } else {
            $content .= "<p>Devi ancora effettuare una prenotazione " . $_SESSION['name'] . '. Che aspetti? Fatti avanti!</p>';
        }
        $content .= "</ul></section>";
        return $content;
    } catch (Throwable $error) {
        return get_error_msg();
    }
}

function get_error_msg($ulteriori_info = "")
{
    $msg_txt = 'A causa di un errore interno al server, questa porzione di pagina è temporaneamente non disponibile.';
    return
        '<p class="warning">' . $msg_txt . '</div>';
}
?>