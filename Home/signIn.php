<?php
try {
    require_once "Utility/utilities.php";
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

try {
    $template = getTemplate('Layouts/main.html');
    $signInSectionhtml = getTemplate('Layouts/signInSection.html');
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

$pageID = 'signInBody';
$title = "SignIn - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  <a href="index.php"><span lang="en">Home</span></a>  >> <span lang="en">SignIn</span></p> ';
$content = $signInSectionhtml;

$errorList = array();

if (isset($_GET['MessageCode'])) {
    switch ($_GET['MessageCode']) {
        case 0:
            array_push($errorList, "<p class='warning'>Formato Username non corretto, deve contenere almeno 2 caratteri e non può contenere solo spazi!</p> ");
            break;
        case 1:
            array_push($errorList, "<p class='warning'>Campo Nome non può essere vuoto, non può contenere solo spazi e nemmeno numeri!</p>");
            break;
        case 2:
            array_push($errorList, "<p class='warning'>Campo Cognome non può essere vuoto, non può contenere solo spazi e nemmeno numeri!</p>");
            break;
        case 3:
            array_push($errorList, "<p class='warning'>Formato dell'email non corretto, deve avere questa forma: nomeutente@dominio.estensione!</p>");
            break;
        case 4:
            array_push($errorList, "<p class='warning'>Formato <span lang='en'>password</span> non corretto!</p>");
            break;
        default:
            array_push($errorList, "<p class='warning'>Qualcosa è andato storto.</p>");
    }
}
$content = str_replace('{{error}}', implode(" ", $errorList), $content);

echo render_page($template, $title, $pageID, $breadcrumbs, 'Registrazione per ordinare Sushi Brombeis, Ristorante sushi via brombeis', 'Accedi al sito ufficiale del miglior ristorante di sushi a Napoli in via Brombeis e poi vieni a trovarci!', $content, 'setSignInChecks();addOnBlur();');
?>