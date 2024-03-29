<?php
try {
    require_once "Utility/utilities.php";
    require_once "DAO/PrenotazioneDAO.php";
    require_once "DAO/TavoloDAO.php";
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

session_start();
//TEMPLATE comune
if (!isset($_SESSION["username"])) {
    header("Location: login.php?Errorcode=2");
}

try {
    $template = getTemplate('Layouts/main.html');
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}
$pageID = 'prenotationId';
$title = "Prenotazione - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span></a> &gt;&gt; <a href="login.php">Area utente</a> &gt;&gt; Prenota</p> ';

if (isset($_SESSION['data_prenotazione_inCorso'])) {
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

    //Prendi i dati della prenotazione
    try {
        $prenotazioneAttiva = PrenotazioneDAO::getPrenotationByUsernameData($_SESSION["username"], $_SESSION['data_prenotazione_inCorso']);
    } catch (Throwable $th) {
        $prenotazioneAttiva = get_error_msg();
    }

    $templatePren = getTemplate('Layouts/ModificaPrenotazioneSection.html');
    $templatePren = str_replace('{{NumeroPersone}}', $prenotazioneAttiva["numero_persone"], $templatePren);
    $templatePren = str_replace('{{NumeroTavolo}}', $prenotazioneAttiva["tavolo"], $templatePren);
    $templatePren = str_replace('{{IndicazioniAggiuntive}}', $prenotazioneAttiva["indicazioni_aggiuntive"], $templatePren);
} else {
    try {
        $templatePren = getTemplate('Layouts/NuovaPrenotazioneSection.html');
    } catch (Throwable $th) {
        $prenotazioneAttiva = get_error_msg();
    }

    if (isset($_GET['n_posti']) && $_GET['n_posti'] > 0) {
        $templatePren = str_replace('{{NumeroPersone}}', $_GET['n_posti'], $templatePren);
    } else {
        $templatePren = str_replace('{{NumeroPersone}}', 1, $templatePren);
    }
    $templatePren = str_replace('{{MaxPosti}}', TavoloDAO::getMaxPosti(), $templatePren);
}

$content = '';

$content .= $templatePren;

$errorList = array();

if (isset($_GET['MessageCode'])) {
    switch ($_GET['MessageCode']) {
        case 1:
            array_push($errorList, "<p class='good'>Prenotazione creata con successo!</p> ");
            break;
        case 2:
            array_push($errorList, "<p class='good'>Prenotazione modificata con successo!</p> ");
            break;
        case 3:
            if (isset($_GET['n_posti']) && $_GET['n_posti'] > 0) {
                array_push($errorList, "<p class='warning'>Impossibile effettuare la prenotazione. 
                       Purtroppo al momento non sono disponibili tavoli da almeno " . $_GET['n_posti'] . "</p> ");
            } else {
                array_push($errorList, "<p class='warning'>Impossibile effettuare la prenotazione. Errore sconosciuto!</p> ");
            }
            break;
        case 4:
            array_push($errorList, "<p class='warning'>Il numero di persone indicato deve essere maggiore di 0!</p> ");
            break;
        case 5:
            array_push($errorList, "<p class='warning'>Prima di poter ordinare dei piatti devi prenotare un tavolo!</p> ");
            break;
        case 6:
            array_push($errorList, "<p class='warning'>Prima di poter visualizzare i tuoi ordini devi prenotare un tavolo!</p> ");
            break;
        case 7:
            array_push($errorList, "<p class='warning'>La tua prenotazione è stata terminata dal proprietario del ristorante!</p> ");
            break;
        case 8:
            array_push($errorList, "<p class='warning'>La tua prenotazione è stata cancellata dal proprietario del ristorante!</p> ");
            break;
        case 9:
            array_push($errorList, "<p class='warning'>A causa di un errore non è possibile modificare la prenotazione.</p> ");
            break;
        case 10:
            array_push($errorList, "<p class='good'>Abbiamo recuperato la tua prenotazione ancora attiva!</p> ");
            break;
        default:
            array_push($errorList, "<p class='warning'>Errore sconosciuto!</p> ");
    }
}

$content = str_replace('{{Message}}', implode(" ", $errorList), $content);



echo render_page($template, $title, $pageID, $breadcrumbs, 'Prenotazione del tavolo da Sushi Brombeis, Prenotazione ristorante sushi via brombeis', 'Prenota il tuo tavolo nel ristorante da sushi Brombeis, ne sarai soddisfatto!', $content, '');
?>